<?php
session_start();
require_once 'config/database.php';

if(!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Calculate total
$stmt = $db->prepare("SELECT c.quantity, p.price 
                      FROM cart c JOIN products p ON c.product_id=p.id
                      WHERE c.user_id=:user_id");
$stmt->execute([':user_id'=>$_SESSION['user_id']]);
$total = 0;
foreach($stmt->fetchAll(PDO::FETCH_ASSOC) as $item){
    $total += $item['price'] * $item['quantity'];
}

if($_SERVER['REQUEST_METHOD']==='POST'){
    // Handle placing order (logic not fully implemented)
    header('Location: thankyou.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(120deg, #3498db, #8e44ad);
            height: 100vh;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .checkout-box {
            background: #fff;
            padding: 40px;
            border-radius: 10px;
            width: 100%;
            max-width: 400px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
            text-align: center;
        }
        .checkout-box h1 {
            margin-bottom: 20px;
            color: #333;
        }
        .checkout-box p {
            font-size: 1.2rem;
            margin-bottom: 30px;
        }
        .place-btn {
            background: #f1c40f;
            color: #333;
            border: none;
            padding: 12px 30px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1.1rem;
            transition: background 0.3s ease;
        }
        .place-btn:hover {
            background: #d4ac0d;
        }
        .back-btn {
            display: inline-block;
            margin-top: 15px;
            padding: 10px 25px;
            background: #ccc;
            color: #333;
            text-decoration: none;
            border-radius: 5px;
            font-size: 1rem;
            transition: background 0.3s ease;
        }
        .back-btn:hover {
            background: #aaa;
        }
    </style>
</head>
<body>
    <div class="checkout-box">
        <h1>Checkout</h1>
        <p>Total Amount: <strong>$<?= number_format($total,2) ?></strong></p>
        <form method="POST">
            <button type="submit" class="place-btn">Place Order</button>
        </form>
        <a href="cart.php" class="back-btn">Back to Cart</a>
    </div>
</body>
</html>
