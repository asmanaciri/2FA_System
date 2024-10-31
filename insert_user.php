<?php
require 'db.php';  

// Test user data
$username = "test_user";
$password = "password123";
$email = "asmaa.nac03@gmail.com";

// Hash the password before storing it
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Insert the user into the database
$stmt = $pdo->prepare("INSERT INTO users (username, password, email) VALUES (?, ?, ?)");
if ($stmt->execute([$username, $hashed_password, $email])) {
    echo "User inserted successfully!";
} else {
    echo "Failed to insert user.";
}

