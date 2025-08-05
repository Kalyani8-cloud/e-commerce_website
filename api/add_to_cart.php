<?php
session_start();
require_once '../config/database.php';

if(!isset($_SESSION['user_id'])) {
    echo json_encode(['status'=>'error','message'=>'Please login first']);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);
$product_id = $data['product_id'];
$quantity = $data['quantity'] ?? 1;

try {
    $stmt = $db->prepare("SELECT id FROM cart WHERE user_id=:user_id AND product_id=:product_id");
    $stmt->execute([':user_id'=>$_SESSION['user_id'], ':product_id'=>$product_id]);
    $existing = $stmt->fetch();

    if($existing) {
        $db->prepare("UPDATE cart SET quantity = quantity + :quantity WHERE id = :id")
            ->execute([':quantity'=>$quantity, ':id'=>$existing['id']]);
    } else {
        $db->prepare("INSERT INTO cart (user_id, product_id, quantity) VALUES (:user_id, :product_id, :quantity)")
            ->execute([':user_id'=>$_SESSION['user_id'], ':product_id'=>$product_id, ':quantity'=>$quantity]);
    }
    echo json_encode(['status'=>'success','message'=>'Product added to cart']);
} catch(Exception $e) {
    echo json_encode(['status'=>'error','message'=>$e->getMessage()]);
}
