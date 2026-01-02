<?php $productId = (int)$_POST['id'];

$conn = Database::getConnection();
$stmt = $conn->prepare("
    UPDATE product
    SET name = ?, description = ?, price = ?, category_id = ?, image = ?
    WHERE id = ?
");

$stmt->execute([
    $_POST['name'],
    $_POST['description'],
    $_POST['price'],
    $_POST['category_id'],
    $_POST['image'],
    $productId
]);

header("Location: admin_products.php");
exit;
?>