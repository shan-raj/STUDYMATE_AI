<?php
session_start();

function respond($data) {
    header('Content-Type: application/json');
    echo json_encode($data);
    file_put_contents('debug.log', "RESPONSE: " . json_encode($data) . "\n", FILE_APPEND);
    exit;
}

file_put_contents('debug.log', "\n---\n" . date('Y-m-d H:i:s') . "\nPOST: " . file_get_contents("php://input") . "\n", FILE_APPEND);
file_put_contents('debug.log', "Session user_id: " . (isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 'NOT SET') . "\n", FILE_APPEND);

if (!isset($_SESSION['user_id'])) {
    respond(["status" => "error", "message" => "User not logged in"]);
}

require_once 'db_config.php';
file_put_contents('debug.log', "DB conn: " . (isset($conn) ? 'SET' : 'NOT SET') . ", Error: " . (isset($conn) && $conn->connect_error ? $conn->connect_error : 'NONE') . "\n", FILE_APPEND);

$user_id = $_SESSION['user_id'];
$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['duration'], $data['distractions'], $data['points'], $data['badges'])) {
    file_put_contents('debug.log', "Invalid data: " . print_r($data, true) . "\n", FILE_APPEND);
    respond(["status" => "error", "message" => "Invalid data provided"]);
}

$duration = (int)$data['duration'];
$distractions = (int)$data['distractions'];
$points = (int)$data['points'];
$badges = is_array($data['badges']) ? implode(",", $data['badges']) : '';
$date = date('Y-m-d H:i:s');

if (!$conn || $conn->connect_error) {
    file_put_contents('debug.log', "DB connection failed: " . ($conn ? $conn->connect_error : "Connection object not found") . "\n", FILE_APPEND);
    respond(["status" => "error", "message" => "DB connection failed: " . ($conn ? $conn->connect_error : "Connection object not found")]);
}

$stmt = $conn->prepare("INSERT INTO session_logs (user_id, duration, distractions, points, badges, session_date) VALUES (?, ?, ?, ?, ?, ?)");
if ($stmt === false) {
    file_put_contents('debug.log', "Prepare failed: " . $conn->error . "\n", FILE_APPEND);
    respond(["status" => "error", "message" => "Failed to prepare statement: " . $conn->error]);
}

$stmt->bind_param("iiiiss", $user_id, $duration, $distractions, $points, $badges, $date);
if ($stmt->execute()) {
    if ($stmt->affected_rows > 0) {
        file_put_contents('debug.log', "Session saved successfully.\n", FILE_APPEND);
        respond(["status" => "success", "message" => "Session saved"]);
    } else {
        file_put_contents('debug.log', "Session not saved, zero rows affected.\n", FILE_APPEND);
        respond(["status" => "failed", "message" => "Session not saved, zero rows affected."]);
    }
} else {
    file_put_contents('debug.log', "Execute failed: " . $stmt->error . "\n", FILE_APPEND);
    respond(["status" => "error", "message" => "Failed to execute statement: " . $stmt->error]);
}

$stmt->close();
$conn->close();
?>
