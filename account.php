<?php
session_start();
require_once "admin/Database.php";

// Check of gebruiker ingelogd is
if (!isset($_SESSION['logged_in']) || !isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
$conn = Database::getConnection();
$userId = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT email, balance, created_at FROM users WHERE id = ?");
$stmt->execute([$userId]);
$user = $stmt->fetch();

if (!$user) {
    die("Gebruiker niet gevonden.");
}

$stmt = $conn->prepare("SELECT * FROM orders WHERE user_id = ? ORDER BY created_at DESC");
$stmt->execute([$userId]);
$orders = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Mijn account</title>
    <link rel="stylesheet" href="Css/normalize.css">
    <link rel="stylesheet" href="Css/account.css">
</head>

<body>
<div class="account-box">
    <h1>Mijn account</h1>
    <p><strong>Email:</strong> <?= htmlspecialchars($user['email']); ?></p>
    <p><strong>Saldo:</strong> <span class="balance">€<?= number_format($user['balance'], 2, ',', '.'); ?></span></p>
    <p><strong>Account aangemaakt:</strong> <?= substr($user['created_at'], 0, 10); ?></p>
    <br>
    <a href="index.php" class="btn">Terug naar webshop</a>
</div>
<div class="order-box">
    <h2>Mijn aankopen</h2>

    <?php if (empty($orders)): ?>
        <p>Je hebt nog geen aankopen gedaan.</p>
    <?php else: ?>
        <?php foreach ($orders as $order): ?>
            <p><strong>Order #<?= $order['id']; ?> - Datum: <?= substr($order['created_at'],0,10); ?> - Totaal: €<?= number_format($order['total'],2,',','.'); ?></strong></p>
            <ul>
                <?php
                $stmt2 = $conn->prepare("SELECT oi.*, p.name FROM order_items oi JOIN product p ON oi.product_id = p.id WHERE oi.order_id = ?");
                $stmt2->execute([$order['id']]);
                $items = $stmt2->fetchAll();
                foreach ($items as $item):
                ?>
                    <li><?= htmlspecialchars($item['name']); ?> - €<?= number_format($item['price'],2,',','.'); ?></li>
                <?php endforeach; ?>
            </ul>
            <hr>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

</body>
</html>
