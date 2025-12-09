<?php
session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit;
}
$products = [
['id' =>1, 'name'=>'Draadloze Oordopjes', 'description'=>' Premuim sound' , 'prijs'=>'89.99', 'image'=>'img/earbuds.png'],
['id'=>2,'name'=>'Smartwatch Pro','description'=>'Fitness & notificaties','prijs'=>'249.99','image'=>'img/smartwatch.png'],

['id'=>3,'name'=>'Draadloos Toetsenbord','description'=>'AZERTY keyboard','prijs'=>'129.99','image'=>'img/keyboard.png'],
['id'=>4,'name'=>'Webcam 4K','description'=>'Crystal clear','prijs'=>'159.99','image'=>'img/webcam.png'],
['id'=>5,'name'=>'Portable Speaker','description'=>'20 uur batterij','prijs'=>'79.99','image'=>'img/Portablespeaker.jpeg'],
['id'=>6,'name'=>'Gaming Muis','description'=>'16.000 DPI','prijs'=>'69.99','image'=>'img/gamingmouse.png']
]

?>

<!DOCTYPE html>
<html lang="en">
    <meta charset="UTF-8">
    <title>Welkom</title>
    <style>
body{
    font-family:Helvetica;
    background:#f5f5f5;
    color:#333;
}

header, nav, .hero, footer {
    text-align:center;
    padding:1.4rem;
}
header{
    background:#667eea;
    color:white;
    display:flex;
    justify-content:space-between;
    align-items:center;
}
nav{
    background:white;
}
nav ul{
    display:flex;
    justify-content:center;
    gap:2rem;
    list-style:none;
}
nav a{
    text-decoration:none;
    color:#667eea;
}
.hero{
    background:#ecebfd;
    padding:2rem;
}

.container{
    max-width:1100px;
    margin:auto;
    padding:20px;
}

.product-grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(250px,1fr));
    gap:1.5rem;
}

.product-card{
    background:white;
    padding:1rem;
    border-radius:12px;
    box-shadow:0 3px 10px rgba(0,0,0,0.1);
}

.product-image{
    width: 100%;
    height: auto;
    display: flex;
    justify-content: center;
}
.product-image img{
    width: 100%;
    height: 180px;
    object-fit: cover;
    border-radius: 10px;
}

.btn{
    width:100%;
    padding:10px;
    border:none;
    border-radius:20px;
    margin-top:10px;
    background:#667eea;
    color:white;
    cursor:pointer;
}

.cart-text{
    color:white;
    font-weight:bold;
}

</style>
</head>

<header>
    <h1>TechGadgets</h1>
    <div style="display:flex;gap:20px;align-items:center;">
        <span class="cart-text">Winkelwagen</span>
        <button class="btn" onclick="addToCart(<?= $p['id'] ?>)">Toevoegen</button>
        <a href="logout.php" style="color:white;">Logout</a>
    </div>
</header>

<nav>
    <ul>
        <li><a href="#home">Home</a></li>
        <li><a href="#products">Producten</a></li>
        <li><a href="#contact">Category</a></li>
    </ul>
</nav>

<section class="hero">
    <h2>Nieuwe Elektronische Gadgets 20% korting</h2>
</section>

<section id="products" class="container">
    <h2 style="text-align:center;margin:1.5rem 0;">Populaire Producten</h2>
    <div class="product-grid">
        <?php $product =[]; foreach($products as $p): ?>
        <div class="product-card">
            <div class="product-image">
                <img src="<?= $p['image'] ?>" alt="<?= $p['name'] ?>">
            </div>
            <h3><?= $p['name'] ?></h3>
            <p><?= $p['description'] ?></p>
            <strong>€<?= $p['prijs'] ?></strong>
            <button class="btn" onclick="addToCart(<?= $p['id'] ?>)">Toevoegen</button>
        </div>
        <?php endforeach; ?>
    </div>
</section>

<footer>
    <p>&copy; 2025 TechGadgets</p>
</footer>

<script>
function addToCart(id) {
    window.location.href = "cart.php?add=" + id;
}
</script>

</body>
</html>


