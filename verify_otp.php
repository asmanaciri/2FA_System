<?php
session_start();
require 'db.php'; 

$message = ''; // Initialize message variable

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $otp_input = $_POST['otp'];

    // Fetch OTP from the database and check if it's still valid
    $stmt = $pdo->prepare("SELECT * FROM otp_codes WHERE user_id = ? AND otp_code = ? AND expiry > NOW()");
    $stmt->execute([$_SESSION['user_id'], $otp_input]);
    
    if ($stmt->rowCount() > 0) {
        $message = "<p class='success-message'>Login successful!</p>";
        // Here I can maybe redirect to a dashboard or a welcome page later
    } else {
        $message = "<p class='error-message'>Invalid OTP or OTP expired</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify OTP</title>
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
        
        /* Container for the OTP form */
        .otp-container {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 300px; /* Adjust width as needed */
        }
        
        /* Form heading */
        .otp-container h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        /* Input fields */
        .otp-container input[type="text"] {
            width: 90%; 
            padding: 10px;
            margin: 8px auto; 
            border: 1px solid #ccc;
            border-radius: 5px;
            display: block; 
        }

        /* Button styling */
        .otp-container button {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .otp-container button:hover {
            background-color: #0056b3;
        }

        /* Message styling */
        .success-message, .error-message {
            text-align: center;
            margin-top: 30px; 
            margin-bottom: 10px; 
            padding-left: 20px; 
            font-size: 20px; 
        }

        .success-message {
            color: green; 
        }

        .error-message {
            color: red; 
        }
    </style>
</head>
<body>

<div class="otp-container">
    <h2>Enter OTP</h2>
    <form action="verify_otp.php" method="POST">
        <label for="otp">OTP:</label>
        <input type="text" name="otp" required placeholder="Enter your OTP"><br>

        <button type="submit">Verify OTP</button>
    </form>

    <!-- Display success or error message -->
    <?php if ($message): ?>
        <?php echo $message; ?>
    <?php endif; ?>
</div>

</body>
</html>
