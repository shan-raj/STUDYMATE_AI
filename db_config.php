<?php
$servername = "localhost";
$username = "testuser";          // your MySQL username
$password = "";  // the password you set (don't keep it blank)
$database = "testuser";  // your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
