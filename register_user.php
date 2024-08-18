<?php
require 'config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Hashing the password
    $email = $_POST['email'];

    // Insert the new user into the database
    $sql = "INSERT INTO users (username, password, email) VALUES (:username, :password, :email)";
    $stmt = $pdo->prepare($sql);

    if ($stmt->execute(['username' => $username, 'password' => $password, 'email' => $email])) {
        echo "User registered successfully!";
    } else {
        echo "Error registering user.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Registration - Summertop Life Bar</title>
</head>
<body>
    <h2>User Registration</h2>
    <form method="POST" action="">
        <label for="username">Username:</label><br>
        <input type="text" name="username" required><br><br>
        
        <label for="password">Password:</label><br>
        <input type="password" name="password" required><br><br>
        
        <label for="email">Email:</label><br>
        <input type="email" name="email" required><br><br>
        
        <button type="submit">Register</button>
    </form>
</body>
</html>
