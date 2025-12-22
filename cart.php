<?php
session_start();
require_once"Classes/product.php";

if (!isset($_SESSION['cart'])){
    $_SESSION['cart']=[];
}
if (isset($_GET['add'])){
    $productId = intval($_GET['add']);
    if (!in_array($productId, $_SESSION['cart'])) {
        $_SESSION['cart'][] = $productId;
    }
    header("Location: cart.php");
    exit;
}
$products= Product::getAll();
$carItems=[];

$totalPrice=0;
foreach($_SESSION['cart'] as $cartItemId){
    foreach($products as $p){
        if($p['id']==$cartItemId){
            $carItems[]=$p;
            $totalPrice += $p['price'];
        }
    }
}
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Winkelwagen</h1>
    <?php if (empty($carItems)): ?>
        <p>Uw winkelwagen is leeg.</p>
    <?php else: ?>
        <?php foreach ($carItems as $item): ?>
            <div>
                <h2><?php echo $item['name']; ?></h2>
                <p><?php echo $item['description']; ?></p>
                <p>Prijs: €<?php echo $item['price']; ?></p>
            </div>
        <?php endforeach; ?>
        <p>Totaalprijs: €<?php echo $totalPrice; ?></p>
    <?php endif; ?>
</body>
</html>