<?php
session_start();
require '../config/db.php';

// Check if the admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../login.php");
    exit;
}

// Handle stock addition
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];

    // Insert the new stock into the database
    $sql = "INSERT INTO stock (name, quantity, price) VALUES (:name, :quantity, :price)";
    $stmt = $pdo->prepare($sql);

    if ($stmt->execute(['name' => $name, 'quantity' => $quantity, 'price' => $price])) {
        $message = "Stock added successfully!";
    } else {
        $message = "Error adding stock.";
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
    <title>Manage Stock - Summertop Life Bar</title>
</head>
<body>
    <h2>Manage Stock</h2>
    <?php if (isset($message)) { echo "<p>$message</p>"; } ?>
    <form method="POST" action="">
        <label for="name">Stock Name:</label><br>
        <input type="text" name="name" required><br><br>
        
        <label for="quantity">Quantity:</label><br>
        <input type="number" name="quantity" required><br><br>
        
        <label for="price">Price:</label><br>
        <input type="number" name="price" step="0.01" required><br><br>
        
        <button type="submit">Add Stock</button>
    </form>

    <h3>Available Stock</h3>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>Action</th>
        </tr>
        <?php foreach ($stocks as $stock): ?>
        <tr>
            <td><?php echo $stock['id']; ?></td>
            <td><?php echo $stock['name']; ?></td>
            <td><?php echo $stock['quantity']; ?></td>
            <td><?php echo $stock['price']; ?></td>
            <td>
                <a href="delete_stock.php?id=<?php echo $stock['id']; ?>" onclick="return confirm('Are you sure?')">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
    <br>
    <a href="index.php">Back to Dashboard</a>
</body>
</html>
