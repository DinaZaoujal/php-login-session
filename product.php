<?php
require_once"Classes/product.php";
$products= Product::getAll();

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Producten</title>

</head>
<body>
  <h1> Producten Lijst</h1>  
  <?php foreach($products as $p): ?>
  <div>
    <h2><?php echo $p['name']; ?></h2>
    <p><?php echo $p['description']; ?></p>
    <p>Prijs: €<?php echo $p['price']; ?></p>
    <?php if(!empty($p['image'])): ?>
    <img src="uploads/<?php echo $p['image']; ?>" width="150">
    <?php endif; ?>
  </div>
  <?php endforeach; ?>

</body>
</html>