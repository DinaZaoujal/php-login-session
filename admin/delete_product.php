<?php
session_start();
require_once "database.php";

if (!isset($_SESSION['logged_in']) || $_SESSION['email'] !== 'admin@admin.com') {
    header("Location: ../login.php");
    exit;
}

if (!isset($_GET['id'])) {
    header("Location: admin_products.php");
    exit;
}

$conn = Database::getConnection();
$stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
$stmt->execute([$_GET['id']]);

header("Location: admin_products.php");
exit;
?>