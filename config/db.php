<?php
// Database configuration
$host = 'localhost';  // or '127.0.0.1'
$dbname = 'club_management';
$username = 'root';  // Your MySQL username
$password = '';      // Your MySQL password

// Create a new PDO instance
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
