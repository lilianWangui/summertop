<?php
session_start();
require '../config/db.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login_user.php");
    exit;
}

// Handle stock sale
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $stock_id = $_POST['stock_id'];
    $quantity = $_POST['quantity'];

    // Get stock details
    $sql = "SELECT * FROM stock WHERE id = :stock_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['stock_id' => $stock_id]);
    $stock = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($stock && $stock['quantity'] >= $quantity) {
        $amount = $quantity * $stock['price'];

        // Insert sale into the database
        $sql = "INSERT INTO sales (stock_id, user_id, quantity, amount) VALUES (:stock_id, :user_id, :quantity, :amount)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'stock_id' => $stock_id,
            'user_id' => $_SESSION['user_id'],
            'quantity' => $quantity,
            'amount' => $amount
        ]);

        // Update stock quantity
        $sql = "UPDATE stock SET quantity = quantity - :quantity WHERE id = :stock_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'quantity' => $quantity,
            'stock_id' => $stock_id
        ]);

        $message = "Stock sold successfully!";
    } else {
        $message = "Insufficient stock quantity.";
    }
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
    <title>Sell Stock - Summertop Life Bar</title>
</head>
<body>
    <h2>Sell Stock</h2>
    <?php if (isset($message)) { echo "<p>$message</p>"; } ?>
    <form method="POST" action="">
        <label for="stock_id">Select Stock:</label><br>
        <select name="stock_id" required>
            <?php foreach ($stocks as $stock): ?>
            <option value="<?php echo $stock['id']; ?>">
                <?php echo $stock['name']; ?> (Quantity: <?php echo $stock['quantity']; ?>, Price: <?php echo $stock['price']; ?>)
            </option>
            <?php endforeach; ?>
        </select><br><br>
        
        <label for="quantity">Quantity:</label><br>
        <input type="number" name="quantity" required><br><br>
        
        <button type="submit">Sell Stock</button>
    </form>
    <br>
    <a href="index.php">Back to Dashboard</a>
</body>
</html>
