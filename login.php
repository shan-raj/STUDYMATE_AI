<?php
// Include the database connection
include 'db_config.php';  // Ensure db.php is in the same folder

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check if the email exists in the database
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // User found
        $row = $result->fetch_assoc();

        // Verify the password
        if (password_verify($password, $row['password'])) {
            session_start();
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['name'] = $row['username']; // Optional: for greeting
            $_SESSION['email'] = $row['email']; // Optional: for user info
            header("Location: dashboard.php");
            exit();
            // Redirect to dashboard or another page
        } else {
            echo "Incorrect password!";
        }
    } else {
        echo "No user found with this email!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Login | StudyMate AI</title>
    <style>
        body { font-family: 'Poppins', sans-serif; }
    </style>
</head>
<body class="bg-gradient-to-br from-blue-100 to-purple-200 min-h-screen flex flex-col items-center justify-center relative overflow-hidden">
    <div class="absolute inset-0 z-0">
        <div class="absolute top-0 left-0 w-72 h-72 bg-blue-300 rounded-full opacity-30 blur-2xl animate-pulse"></div>
        <div class="absolute bottom-0 right-0 w-96 h-96 bg-purple-300 rounded-full opacity-30 blur-2xl animate-pulse"></div>
    </div>
    <nav class="fixed top-0 left-0 w-full bg-white bg-opacity-90 backdrop-filter backdrop-blur-lg z-50 shadow-sm">
        <div class="max-w-2xl mx-auto px-4 flex justify-between h-16 items-center">
            <div class="flex items-center">
                <img class="h-10 w-10 rounded-full" src="logo.png" alt="StudyMate AI Logo">
                <span class="ml-3 text-xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-indigo-600 to-purple-600">StudyMate AI</span>
            </div>
            <div class="flex items-center space-x-4">
                <a href="index.php" class="text-gray-700 hover:text-indigo-600 font-medium transition-colors duration-200">Home</a>
                <a href="register.php" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 transition duration-200">Sign up</a>
            </div>
        </div>
    </nav>
    <div class="relative z-10 flex flex-col items-center justify-center w-full max-w-md p-8 bg-white bg-opacity-90 rounded-2xl shadow-2xl mt-24">
        <div class="mb-6">
            <img src="logo.png" alt="StudyMate AI Logo" class="w-20 h-20 mx-auto rounded-full shadow-lg border-4 border-blue-200">
        </div>
        <h2 class="text-3xl font-bold text-center text-blue-700 mb-2">Login to StudyMate AI</h2>
        <p class="text-gray-600 text-center mb-6">Welcome back! Please login to your account.</p>
        <form action="login.php" method="POST" class="space-y-5 w-full">
            <div>
                <label for="email" class="block text-gray-700 font-semibold mb-1">Email</label>
                <input type="email" name="email" id="email" required class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>
            <div>
                <label for="password" class="block text-gray-700 font-semibold mb-1">Password</label>
                <input type="password" name="password" id="password" required class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>
            <div class="flex justify-center">
                <input type="submit" value="Login" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded transition duration-200 cursor-pointer">
            </div>
        </form>
        <div class="text-center mt-6">
            <a href="register.php" class="text-blue-600 hover:underline">Don't have an account? Register</a>
        </div>
    </div>
    <footer class="relative z-10 mt-10 text-gray-500 text-sm text-center">
        &copy; 2025 StudyMate AI. All rights reserved.
    </footer>
</body>
</html>
