<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $action = $_POST['action'];

    if ($action === 'start') {
        $_SESSION['start_time'] = date("Y-m-d H:i:s");
        header("Location: dashboard.php");
    } elseif ($action === 'stop') {
        unset($_SESSION['start_time']);
        header("Location: session_history.php"); // redirect after stopping
    }
}
?>
