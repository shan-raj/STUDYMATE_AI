<?php
session_start();
header('Content-Type: application/json');

// Check user session email
if (!isset($_SESSION['email'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized: No session found']);
    exit;
}

$email = $_SESSION['email'];

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Only POST requests allowed']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);
$messages = $input['messages'] ?? null;

if (!$messages || !is_array($messages)) {
    http_response_code(400);
    echo json_encode(['error' => 'No messages provided or invalid format']);
    exit;
}

require_once 'db_config.php';

// Generate unique chat id for this session (or get it from client if you want)
$chat_id = uniqid('chat_', true);

// Save chat session into chats table
$stmtChat = $conn->prepare("INSERT INTO chats (chat_id, user_email) VALUES (?, ?)");
$stmtChat->bind_param("ss", $chat_id, $email);
if (!$stmtChat->execute()) {
    http_response_code(500);
    echo json_encode(['error' => 'Failed to create chat session']);
    exit;
}
$stmtChat->close();

// Function to save messages in DB
function saveMessage($conn, $chat_id, $role, $content) {
    $stmt = $conn->prepare("INSERT INTO messages (chat_id, role, content) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $chat_id, $role, $content);
    $stmt->execute();
    $stmt->close();
}

// Save all user messages from $messages array (only those with role 'user')
foreach ($messages as $msg) {
    if (isset($msg['role'], $msg['content']) && $msg['role'] === 'user') {
        saveMessage($conn, $chat_id, 'user', $msg['content']);
    }
}

// Call Hugging Face API
$apiKey = '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';
$url = 'https://router.huggingface.co/novita/v3/openai/chat/completions';

$payload = json_encode([
    'messages' => $messages,
    'model' => 'deepseek/deepseek-v3-0324',
    'stream' => false
]);

$options = [
    'http' => [
        'method'  => 'POST',
        'header'  => [
            "Authorization: Bearer $apiKey",
            "Content-Type: application/json"
        ],
        'content' => $payload,
        'ignore_errors' => true
    ]
];

$context = stream_context_create($options);
$response = file_get_contents($url, false, $context);

if ($response === false) {
    http_response_code(500);
    echo json_encode(['error' => 'Failed to connect to the Hugging Face API']);
    exit;
}

$responseData = json_decode($response, true);

if (isset($responseData['choices'][0]['message']['content'])) {
    $botReply = $responseData['choices'][0]['message']['content'];

    // Save bot reply
    saveMessage($conn, $chat_id, 'assistant', $botReply);

    echo json_encode(['reply' => $botReply]);
} elseif (isset($responseData['error'])) {
    http_response_code(500);
    echo json_encode(['error' => $responseData['error']['message'] ?? 'Unknown error']);
} else {
    http_response_code(500);
    echo json_encode(['error' => 'Unexpected API response']);
}

$conn->close();
