<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login_user.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Dashboard - Summertop Life Bar</title>
</head>
<body>
    <h1>Welcome, <?php echo $_SESSION['user_username']; ?>!</h1>
    <h2>User Dashboard</h2>
    <ul>
        <li><a href="view_stock.php">View Stock</a></li>
        <li><a href="sell_stock.php">Sell Stock</a></li>
        <li><a href="view_balance.php">View Balance</a></li>
        <li><a href="../logout.php">Logout</a></li>
    </ul>
</body>
</html>
