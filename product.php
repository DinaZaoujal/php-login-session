<?php
session_start();
require_once "Classes/Product.php";
$products = Product::getAll();
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Producten</title>
    <link rel="stylesheet" href="Css/normalize.css">
    <link rel="stylesheet" href="Css/product.css">
</head>
<body>

<h1>Producten Lijst</h1>

<?php foreach($products as $p): ?>
<div class="product-item">
    <h2><?= htmlspecialchars($p['name']); ?></h2>
    <p><?= htmlspecialchars($p['description']); ?></p>
    <p>Prijs: €<?= number_format($p['price'],2,',','.'); ?></p>

    <?php if(!empty($p['image'])): ?>
        <img src="img/<?= htmlspecialchars($p['image']); ?>" width="150">
    <?php endif; ?>

    <br><br>
    <a href="product_detail.php?id=<?= $p['id']; ?>" class="btn">Bekijk product</a>
    
    <?php if(isset($_SESSION['user_id'])): ?>
        <a href="cart.php?add=<?= $p['id']; ?>" class="btn">In winkelwagen</a>
    <?php else: ?>
        <p><a href="login.php">Log in</a> om te kopen.</p>
    <?php endif; ?>
</div>
<hr>
<?php endforeach; ?>

</body>
</html>
