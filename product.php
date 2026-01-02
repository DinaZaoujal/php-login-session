<?php if (isset($_SESSION['user_id'])): ?>
    <h3>Geef een rating</h3>

    <label>Rating (1–5)</label><br>
    <select id="rating">
        <option value="1">1 ⭐</option>
        <option value="2">2 ⭐⭐</option>
        <option value="3">3 ⭐⭐⭐</option>
        <option value="4">4 ⭐⭐⭐⭐</option>
        <option value="5">5 ⭐⭐⭐⭐⭐</option>
    </select><br><br>

    <label>Comment</label><br>
    <textarea id="comment"></textarea><br><br>

    <button onclick="sendRating(<?= $product['id'] ?>)">
        Verstuur
    </button>

    <div id="rating-message"></div>
<?php else: ?>
    <p><a href="login.php">Log in</a> om een rating te geven.</p>
<?php endif; ?>


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