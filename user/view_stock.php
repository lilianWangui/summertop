<?php
session_start();
require '../config/db.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login_user.php");
    exit;
}

// Retrieve all stock items from the database
$sql = "SELECT * FROM stock";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$stocks = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Stock - Summertop Life Bar</title>
</head>
<body>
    <h2>View Stock</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Quantity</th>
            <th>Price</th>
        </tr>
        <?php foreach ($stocks as $stock): ?>
        <tr>
            <td><?php echo $stock['id']; ?></td>
            <td><?php echo $stock['name']; ?></td>
            <td><?php echo $stock['quantity']; ?></td>
            <td><?php echo $stock['price']; ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
    <br>
    <a href="index.php">Back to Dashboard</a>
</body>
</html>
