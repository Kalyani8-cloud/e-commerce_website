<?php
session_start();
require_once '../config/database.php';

// Check admin access
if(!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: ../login.php');
    exit;
}

// Fetch summary counts
try {
    $productCount = $db->query("SELECT COUNT(*) FROM products")->fetchColumn();
    $orderCount = $db->query("SELECT COUNT(*) FROM orders")->fetchColumn();
    $userCount = $db->query("SELECT COUNT(*) FROM users")->fetchColumn();
} catch(PDOException $e) {
    die("Error fetching dashboard data: ".$e->getMessage());
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <style>
        body { font-family: Arial; margin:0; padding:0; background:#f5f5f5;}
        header { background:#333; color:#fff; padding:10px; }
        .container { width:90%; margin:20px auto; }
        .cards { display:grid; grid-template-columns:repeat(auto-fill,minmax(250px,1fr)); gap:20px; }
        .card { background:#fff; padding:20px; text-align:center; border-radius:5px; box-shadow:0 2px 5px rgba(0,0,0,0.2); }
        a { text-decoration:none; color:#333; font-weight:bold; display:inline-block; margin-top:10px; }
    </style>
</head>
<body>
<header>
    <h1>Admin Dashboard</h1>
</header>
<div class="container">
    <div class="cards">
        <div class="card">
            <h2><?php echo $productCount; ?></h2>
            <p>Total Products</p>
            <a href="products.php">Manage Products</a>
        </div>
        <div class="card">
            <h2><?php echo $orderCount; ?></h2>
            <p>Total Orders</p>
            <a href="#">View Orders</a>
        </div>
        <div class="card">
            <h2><?php echo $userCount; ?></h2>
            <p>Total Users</p>
            <a href="#">Manage Users</a>
        </div>
    </div>
</div>
</body>
</html>
