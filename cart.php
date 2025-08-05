<?php
session_start();
require_once 'config/database.php';

if(!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$stmt = $db->prepare("SELECT c.id, c.quantity, p.name, p.price, p.image_url 
                      FROM cart c JOIN products p ON c.product_id=p.id
                      WHERE c.user_id=:user_id");
$stmt->execute([':user_id'=>$_SESSION['user_id']]);
$cart_items = $stmt->fetchAll(PDO::FETCH_ASSOC);

$total = 0;
foreach($cart_items as $item){
    $total += $item['price'] * $item['quantity'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart</title>
    <style>
        body {
    font-family: Arial, sans-serif;
    padding: 20px;
    margin: 0;
    background: linear-gradient(135deg, #f0f4f8, #d9e4ec);
}
h1 {
    margin-bottom: 20px;
    color: #333;
}
table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 20px;
    background: #ffffff;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}
table th, table td {
    border: 1px solid #ddd;
    padding: 10px;
    text-align: left;
}
table th {
    background: #f7f7f7;
    color: #333;
    font-weight: bold;
}
img {
    width: 100px;
    height: auto;
    border-radius: 5px;
}
.total {
    font-size: 1.5rem;
    font-weight: bold;
    margin-top: 20px;
    color: #222;
}
.buttons {
    display: flex;
    gap: 15px;
    margin-top: 20px;
}
.btn {
    display: inline-block;
    padding: 10px 20px;
    background: #333;
    color: #fff;
    text-decoration: none;
    border-radius: 5px;
    transition: background 0.3s ease, transform 0.2s ease;
}
.btn:hover {
    background: #555;
    transform: translateY(-2px);
}
.checkout-btn {
    background: #28a745;
}
.checkout-btn:hover {
    background: #218838;
}

    </style>
</head>
<body>
    <h1>Your Shopping Cart</h1>
    <?php if(count($cart_items) > 0): ?>
        <table>
            <tr>
                <th>Image</th>
                <th>Name</th>
                <th>Price</th>
                <th>Quantity</th>
            </tr>
            <?php foreach($cart_items as $item): ?>
            <tr>
                <td><img src="<?= $item['image_url'] ?>" alt="<?= $item['name'] ?>"></td>
                <td><?= $item['name'] ?></td>
                <td>$<?= number_format($item['price'], 2) ?></td>
                <td><?= $item['quantity'] ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
        <div class="total">Total: $<?= number_format($total, 2) ?></div>
        <div class="buttons">
            <a href="products.html" class="btn">Back to Products</a>
            <a href="checkout.php" class="btn checkout-btn">Proceed to Checkout</a>
        </div>
    <?php else: ?>
        <p>Your cart is empty.</p>
        <a href="products.html" class="btn">Back to Products</a>
    <?php endif; ?>
</body>
</html>
