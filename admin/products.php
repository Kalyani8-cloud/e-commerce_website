<?php 
// admin/products.php 
session_start(); 
require_once '../config/database.php'; 
 
// Check if user is admin 
if(!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') 
{ 
    header('Location: ../login.php'); 
    exit; 
} 
 
// Handle form submissions 
if($_SERVER['REQUEST_METHOD'] === 'POST') { 
    if(isset($_POST['add_product'])) { 
        // Add new product 
        $name = $_POST['name']; 
        $description = $_POST['description']; 
        $price = $_POST['price']; 
        $category = $_POST['category']; 
        $stock = $_POST['stock']; 
         
        // Handle image upload 
        $image_url = ''; 
        if(isset($_FILES['image']) { 
            $target_dir = "../uploads/"; 
            $target_file = $target_dir . 
basename($_FILES["image"]["name"]); 
            if(move_uploaded_file($_FILES["image"]["tmp_name"], 
$target_file)) { 
                $image_url = "uploads/" . 
basename($_FILES["image"]["name"]); 
            } 
        } 
         
        try { 
            $db = new PDO("mysql:host=" . DB_HOST . ";dbname=" . 
DB_NAME, DB_USER, DB_PASS); 
            $query = "INSERT INTO products (name, description, price, 
image_url, category, stock_quantity)  
                      VALUES 
(:name, :description, :price, :image_url, :category, :stock)"; 
            $stmt = $db->prepare($query); 
            $stmt->execute([ 
                ':name' => $name, 
                ':description' => $description, 
                ':price' => $price, 
                ':image_url' => $image_url, 
                ':category' => $category, 
                ':stock' => $stock 
            ]); 
             
            $_SESSION['message'] = "Product added successfully!"; 
            header("Location: products.php"); 
            exit; 
        } catch(PDOException $e) { 
            $error = "Database error: " . $e->getMessage(); 
        } 
    } 
} 
 
// Get all products 
try { 
    $db = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, 
DB_USER, DB_PASS); 
    $query = "SELECT * FROM products ORDER BY created_at DESC"; 
    $stmt = $db->query($query); 
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC); 
} catch(PDOException $e) { 
    die("Database error: " . $e->getMessage()); 
} 
?> 
 
<!DOCTYPE html> 
<html lang="en"> 
<head> 
    <meta charset="UTF-8"> 
    <title>Manage Products - Admin Panel</title> 
    <style> 
        .admin-container { 
            max-width: 1200px; 
            margin: 0 auto; 
            padding: 20px; 
        } 
        .admin-header { 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
            margin-bottom: 20px; 
        } 
        .product-form { 
            background: #f9f9f9; 
            padding: 20px; 
            border-radius: 5px; 
            margin-bottom: 30px; 
        } 
        .form-group { 
            margin-bottom: 15px; 
        } 
        .form-group label { 
            display: block; 
            margin-bottom: 5px; 
            font-weight: bold; 
        } 
        .form-control { 
            width: 100%; 
            padding: 8px; 
            border: 1px solid #ddd; 
            border-radius: 4px; 
        } 
        .btn { 
            background: #333; 
            color: white; 
            border: none; 
            padding: 8px 15px; 
            border-radius: 4px; 
            cursor: pointer; 
        } 
        .products-table { 
            width: 100%; 
            border-collapse: collapse; 
        } 
        .products-table th, .products-table td { 
            border: 1px solid #ddd; 
            padding: 8px; 
            text-align: left; 
        } 
        .products-table th { 
            background-color: #f2f2f2; 
        } 
        .products-table img { 
            max-width: 50px; 
            max-height: 50px; 
        } 
        .action-btn { 
            padding: 5px 10px; 
            margin-right: 5px; 
        } 
    </style> 
</head> 
<body> 
    <div class="admin-container"> 
        <div class="admin-header"> 
            <h1>Manage Products</h1> 
            <a href="dashboard.php" class="btn">Back to Dashboard</a> 
        </div> 
         
        <div class="product-form"> 
            <h2>Add New Product</h2> 
            <form method="POST" enctype="multipart/form-data"> 
                <div class="form-group"> 
                    <label for="name">Product Name</label> 
                    <input type="text" id="name" name="name" 
class="form-control" required> 
                </div> 
                <div class="form-group"> 
                    <label for="description">Description</label> 
                    <textarea id="description" name="description" 
class="form-control" rows="3" required></textarea> 
                </div> 
                <div class="form-group"> 
                    <label for="price">Price</label> 
                    <input type="number" id="price" name="price" 
step="0.01" class="form-control" required> 
                </div> 
                <div class="form-group"> 
                    <label for="category">Category</label> 
                    <input type="text" id="category" name="category" 
class="form-control" required> 
                </div> 
                <div class="form-group"> 
                    <label for="stock">Stock Quantity</label> 
                    <input type="number" id="stock" name="stock" 
class="form-control" required> 
                </div> 
                <div class="form-group"> 
                    <label for="image">Product Image</label> 
                    <input type="file" id="image" name="image" 
class="form-control"> 
                </div> 
                <button type="submit" name="add_product" 
class="btn">Add Product</button> 
            </form> 
        </div> 
         
        <h2>Product List</h2> 
        <table class="products-table"> 
            <thead> 
                <tr> 
                    <th>ID</th> 
                    <th>Image</th> 
                    <th>Name</th> 
                    <th>Price</th> 
                    <th>Stock</th> 
                    <th>Actions</th> 
                </tr> 
            </thead> 
            <tbody> 
                <?php foreach($products as $product): ?> 
                    <tr> 
                        <td><?= $product['id'] ?></td> 
                        <td> 
                            <?php if($product['image_url']): ?> 
                                <img src="../<?= 
htmlspecialchars($product['image_url']) ?>" alt="<?= 
htmlspecialchars($product['name']) ?>"> 
                            <?php endif; ?> 
                        </td> 
                        <td><?= 
htmlspecialchars($product['name']) ?></td> 
                        <td>$<?= number_format($product['price'], 
2) ?></td> 
                        <td><?= $product['stock_quantity'] ?></td> 
                        <td> 
                            <a href="edit_product.php?id=<?= 
$product['id'] ?>" class="btn action-btn">Edit</a> 
                            <a href="delete_product.php?id=<?= 
$product['id'] ?>" class="btn action-btn" onclick="return confirm('Are 
you sure?')">Delete</a> 
                        </td> 
                    </tr> 
                <?php endforeach; ?> 
            </tbody> 
        </table> 
    </div> 
</body> 
</html> 