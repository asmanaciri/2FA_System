<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

// Generate a random 6-digit OTP
$otp = rand(100000, 999999);

// Log OTP code for debugging (can be removed later)
error_log("OTP Code: " . $otp);

// Set OTP expiry (5 minutes from now)
$expiry = date("Y-m-d H:i:s", strtotime("+5 minutes"));

// Save OTP to the database
$stmt = $pdo->prepare("INSERT INTO otp_codes (user_id, otp_code, expiry) VALUES (?, ?, ?)");
$stmt->execute([$_SESSION['user_id'], $otp, $expiry]); 

// Email setup with MailHog
$to = $_SESSION['email'];
$subject = "Your OTP Code";
$message = "Your one-time password is: " . $otp;
$headers = "From: no-reply@yourdomain.com";

// Using PHP's mail function with MailHog
if (mail($to, $subject, $message, $headers)) {
    error_log("Email sent successfully to $to"); // Log success
} else {
    error_log("Failed to send email"); // Log failure
}

// Redirect to OTP verification page
header('Location: verify_otp.php');
exit();
