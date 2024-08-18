<?php
session_start();

// Check if the admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../login.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard - Summertop Life Bar</title>
</head>
<body>
    <h1>Welcome, <?php echo $_SESSION['admin_username']; ?>!</h1>
    <h2>Admin Dashboard</h2>
    <ul>
        <li><a href="manage_users.php">Manage Users</a></li>
        <li><a href="manage_stock.php">Manage Stock</a></li>
        <li><a href="view_sales.php">View Sales</a></li>
        <li><a href="../logout.php">Logout</a></li>
    </ul>
</body>
</html>
