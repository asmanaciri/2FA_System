<?php
// Database configuration
$host = "localhost"; 
$dbname = "2fa_system"; 
$username = "root"; 
$password = "";  

try {
    // PDO connection to MySQL
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    
} catch (PDOException $e) {
    // If the connection fails, display the error message
    echo "Connection failed: " . $e->getMessage();
}




