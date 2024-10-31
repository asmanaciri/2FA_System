<?php
session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Fetch user from database
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        // Credentials are valid, generate OTP
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['email'] = $user['email'];

        // Redirect to OTP page
        header('Location: otp_email.php');
        exit();
    } else {
        echo "<p style='color: red; text-align: center;'>Invalid username or password</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        /* General page styling */
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f2f5;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        
        /* Container for the login form */
        .login-container {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 300px;
        }
        
        /* Form heading */
        .login-container h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        /* Input fields */
        .login-container input[type="text"],
        .login-container input[type="password"] {
            width: 90%;
            padding: 10px;
            margin: 8px auto;
            border: 1px solid #ccc;
            border-radius: 5px;
            display: block;
        }

        /* Button styling */
        .login-container button {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .login-container button:hover {
            background-color: #0056b3;
        }

        /* Small text for links */
        .login-container p {
            text-align: center;
            margin-top: 15px;
            font-size: 14px;
        }

        .login-container p a {
            color: #007bff;
            text-decoration: none;
        }

        .login-container p a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="login-container">
    <h2>Login</h2>
    <!-- The form that sends username and password to index.php -->
    <form action="index.php" method="POST">
        <label for="username">Username:</label>
        <input type="text" name="username" placeholder="Enter your username" required><br>

        <label for="password">Password:</label>
        <input type="password" name="password" placeholder="Enter your password" required><br>

        <button type="submit">Login</button>
    </form>
</div>

</body>
</html>
