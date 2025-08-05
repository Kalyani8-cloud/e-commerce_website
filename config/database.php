<?php
define('DB_HOST','127.0.0.1');
define('DB_NAME','ecommerce');
define('DB_USER','root');
define('DB_PASS','');

try {
    $db = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME,DB_USER,DB_PASS);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("DB Connection failed: ".$e->getMessage());
}
?>
