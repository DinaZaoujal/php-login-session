<?php
session_start();

if (!isset($_SESSION['logged_in'])) {
    header("Location: login.php");
    exit;
}

$dbPath = __DIR__ . '/db.php';

if (!file_exists($dbPath)) {
    die('FOUT: db.php niet gevonden in ' . __DIR__);
}

require_once $dbPath;

require_once "Classes/Category.php";
require_once "Classes/Product.php";
require_once "Classes/Rating.php"; 


$categories = Category::getAll($conn);

$selectedCategory = $_GET['category'] ?? null;

if ($selectedCategory) {
    $products = Product::getByCategory((int)$selectedCategory);
} else {
    $stmt = $conn->prepare("SELECT * FROM product");
    $stmt->execute();
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>TechGadgets</title>
    <link rel="stylesheet" href="Css/normalize.css">  
    <link rel="stylesheet" href="Css/index.css">
</head>

<body>

<header>
    <h1>TechGadgets</h1>
    <div style="display:flex;gap:20px;align-items:center;">
        <a href="cart.php" style="color:white;">Winkelwagen</a>
        <a href="logout.php" style="color:white;">Logout</a>
    </div>
</header>

<nav>
    <ul>
        <li><a href="account.php">account</a></li>
        <li><a href="#products">Producten</a></li>
    </ul>
</nav>

<section class="hero">
    <h2>Nieuwe Elektronische Gadgets - 20% korting</h2>
</section>

<section id="products" class="container">
    <h2>Populaire Producten</h2>

    <form method="get" style="margin-bottom:20px;">
        <select name="category">
            <option value="">Alle categorieën</option>
            <?php foreach ($categories as $cat): ?>
                <option value="<?= $cat['id']; ?>"
                    <?= ($selectedCategory == $cat['id']) ? 'selected' : ''; ?>>
                    <?= htmlspecialchars($cat['name']); ?>
                </option>
            <?php endforeach; ?>
        </select>
        <button type="submit">Filter</button>
    </form>

    <div class="product-grid">
        <?php foreach ($products as $p): ?>
            <div class="product-card">

                <img src="img/<?= htmlspecialchars($p['image']); ?>" alt="">

                <h3><?= htmlspecialchars($p['name']); ?></h3>
                <p><?= htmlspecialchars($p['description']); ?></p>

                <?php
                $avgRating = Rating::getAverage($p['id']);
                ?>
                <p>
                    <?php if ($avgRating > 0): ?>
                        ⭐ <?= $avgRating; ?>/5
                    <?php else: ?>
                        ⭐ Geen reviews
                    <?php endif; ?>
                </p>

                <strong>
                    €<?= number_format((float)$p['price'], 2, ',', '.'); ?>
                </strong>

                <button class="btn" onclick="addToCart(<?= (int)$p['id']; ?>)">
                    Toevoegen
                </button>

                <a href="product_detail.php?id=<?= (int)$p['id']; ?>">
                    Bekijk details
                </a>

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
