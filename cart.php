<?php
session_start();
require_once "Classes/product.php";
require_once "admin/Database.php";

// Zorg dat cart altijd bestaat
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Voeg product toe aan cart
if (isset($_GET['add'])) {
    $productId = intval($_GET['add']);
    if (isset($_SESSION['cart'][$productId])) {
        $_SESSION['cart'][$productId] += 1;
    } else {
        $_SESSION['cart'][$productId] = 1;
    }
    header("Location: cart.php");
    exit;
}

// Verwijder product uit cart
if (isset($_GET['remove'])) {
    $productId = intval($_GET['remove']);
    unset($_SESSION['cart'][$productId]);
    header("Location: cart.php");
    exit;
}

// Checkout
if (isset($_POST['checkout'])) {

    if (!isset($_SESSION['logged_in']) || !isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit;
    }

    $conn = Database::getConnection();
    $userId = $_SESSION['user_id'];

    // Bereken totaalprijs
    $total = 0;
    foreach ($_SESSION['cart'] as $id => $qty) {
        $product = Product::getById($id);
        $total += $product['price'] * $qty;
    }

    // Haal balance op
    $stmt = $conn->prepare("SELECT balance FROM users WHERE id = ?");
    $stmt->execute([$userId]);
    $balance = round($stmt->fetchColumn(), 2);

    if ($balance < $total) {
        die("❌ Onvoldoende saldo. Uw balance: €" . number_format($balance,2,',','.') . ", totaal: €" . number_format($total,2,',','.'));
    }

    // Insert order
    $stmt = $conn->prepare("INSERT INTO orders (user_id, total) VALUES (?, ?)");
    $stmt->execute([$userId, $total]);
    $orderId = $conn->lastInsertId();

    // Insert order items
    $stmtItem = $conn->prepare("INSERT INTO order_items (order_id, product_id, price) VALUES (?, ?, ?)");
    foreach ($_SESSION['cart'] as $id => $qty) {
        $product = Product::getById($id);
        for ($i = 0; $i < $qty; $i++) {
            $stmtItem->execute([$orderId, $id, $product['price']]);
        }
    }

    // Balance update
    $stmt = $conn->prepare("UPDATE users SET balance = balance - ? WHERE id = ?");
    $stmt->execute([$total, $userId]);
    $_SESSION['cart'] = [];

    header("Location: cart.php?success=1");
    exit;
}

// haal alle producten uit cart
$allProducts = Product::getAll();
$cartItems = [];
$totalPrice = 0.0;
foreach ($_SESSION['cart'] as $id => $qty) {
    foreach ($allProducts as $p) {
        if ($p['id'] == $id) {
            $p['qty'] = $qty;
            $p['subtotal'] = $p['price'] * $qty;
            $totalPrice += $p['subtotal'];
            $cartItems[] = $p;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Winkelwagen</title>
  <link rel="stylesheet" href="Css/normalize.css">  
  <link rel="stylesheet" href="/Css/cart.css">  
</head>

<body>

<header>
    <nav>
        <ul>
            <li><a href="index.php"> Home</a></li>
            <li><a href="account.php">Account</a></li>
        </ul>
    </nav>
</header>

<div class="container">
    <h1>Winkelwagen</h1>

    <?php if (isset($_GET['success'])): ?>
        <p class="success">✅ Aankoop geslaagd!</p>
    <?php endif; ?>

    <?php if(empty($cartItems)): ?>
        <p>Uw winkelwagen is leeg.</p>
    <?php else: ?>
        <?php foreach($cartItems as $item): ?>
            <div class="cart-item">
                <h2><?= htmlspecialchars($item['name']); ?> (x<?= $item['qty']; ?>)</h2>
                <p><?= htmlspecialchars($item['description']); ?></p>
                <p>Prijs: €<?= number_format($item['price'],2,',','.'); ?></p>
                <p>Subtotaal: €<?= number_format($item['subtotal'],2,',','.'); ?></p>
                <a href="cart.php?remove=<?= $item['id']; ?>" class="btn">Verwijderen</a>
            </div>
        <?php endforeach; ?>

        <h3>Totaalprijs: €<?= number_format($totalPrice,2,',','.'); ?></h3>

        <form method="post">
            <button type="submit" name="checkout" class="btn">Afrekenen</button>
        </form>
    <?php endif; ?>
</div>

</body>
</html>
