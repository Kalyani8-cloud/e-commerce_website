<?php
header('Content-Type: application/json');
require_once '../config/database.php';

$query = $db->query("SELECT * FROM products");
$products = $query->fetchAll(PDO::FETCH_ASSOC);

echo json_encode(['success'=>true,'data'=>$products]);
?>
