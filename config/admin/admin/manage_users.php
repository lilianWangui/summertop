<?php
session_start();
require '../config/db.php';

// Check if the admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../login.php");
    exit;
}

// Handle user addition
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Hashing the password
    $email = $_POST['email'];

    // Insert the new user into the database
    $sql = "INSERT INTO users (username, password, email) VALUES (:username, :password, :email)";
    $stmt = $pdo->prepare($sql);

    if ($stmt->execute(['username' => $username, 'password' => $password, 'email' => $email])) {
        $message = "User added successfully!";
    } else {
        $message = "Error adding user.";
    }
}

// Retrieve all users from the database
$sql = "SELECT * FROM users";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Users - Summertop Life Bar</title>
</head>
<body>
    <h2>Manage Users</h2>
    <?php if (isset($message)) { echo "<p>$message</p>"; } ?>
    <form method="POST" action="">
        <label for="username">Username:</label><br>
        <input type="text" name="username" required><br><br>
        
        <label for="password">Password:</label><br>
        <input type="password" name="password" required><br><br>
        
        <label for="email">Email:</label><br>
        <input type="email" name="email" required><br><br>
        
        <button type="submit">Add User</button>
    </form>

    <h3>Registered Users</h3>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Email</th>
            <th>Action</th>
        </tr>
        <?php foreach ($users as $user): ?>
        <tr>
            <td><?php echo $user['id']; ?></td>
            <td><?php echo $user['username']; ?></td>
            <td><?php echo $user['email']; ?></td>
            <td>
                <a href="edit_user.php?id=<?php echo $user['id']; ?>">Edit</a> | 
                <a href="delete_user.php?id=<?php echo $user['id']; ?>" onclick="return confirm('Are you sure?')">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
    <br>
    <a href="index.php">Back to Dashboard</a>
</body>
</html>
