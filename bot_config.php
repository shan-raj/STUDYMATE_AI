<?php
session_start(); // Start the session

// header('Content-Type: application/json');

// Check if email is set in session
if (!isset($_SESSION['email'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized: No session found']);
    exit;
}

require_once 'db_config.php';

$email = $_SESSION['email'];

// Generate unique chat ID
$chat_id = uniqid('chat_', true);

// Insert into chats table
$stmt = $conn->prepare("INSERT INTO chats (chat_id, user_email) VALUES (?, ?)");
$stmt->bind_param("ss", $chat_id, $email);

if ($stmt->execute()) {
    // echo json_encode(['chat_id' => $chat_id]);
    $chat_idd = $chat_id;
} else {
    http_response_code(500);
    exit(json_encode(['error' => 'Failed to create chat session']));
}

$stmt->close();
$conn->close();

?>