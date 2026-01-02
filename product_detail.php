<?php
session_start();
require_once "admin/database.php";
require_once "Classes/Product.php";
require_once "Classes/Rating.php";

$productId = intval($_GET['id'] ?? 0);
$product = Product::getById($productId);

if (!$product) {
    die("Product niet gevonden");
}

$ratings = Rating::getByProduct($productId);
$average = Rating::getAverage($productId);
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($product['name']); ?></title>
    <link rel="stylesheet" href="Css/normalize.css">   
    <link rel="stylesheet" href="Css/product_detail.css">
</head>
<body>

<div class="navbar">
    <div>
        <a href="index.php">Home</a>
        <a href="cart.php">Winkelwagen</a>
        <a href="account.php">Account</a>
    </div>
</div>

<div class="product-box">
    <h1><?= htmlspecialchars($product['name']); ?></h1>

    <img src="img/<?= htmlspecialchars($product['image']); ?>" class="product-image">

    <p><?= htmlspecialchars($product['description']); ?></p>
    <p><strong>Prijs:</strong> €<?= number_format($product['price'],2,',','.'); ?></p>
    <p><strong>Gemiddelde rating:</strong> <?= $average ?: 'Nog geen reviews'; ?></p>

    <h2>Reviews</h2>

    <div id="reviewsContainer">
        <?php if (empty($ratings)): ?>
            <p>Er zijn nog geen reviews.</p>
        <?php else: ?>
            <?php foreach ($ratings as $r): ?>
                <div class="review" id="review-<?= $r['id']; ?>">
                    <strong><?= htmlspecialchars($r['email']); ?></strong><br>
                    Rating: <?= (int)$r['rating']; ?>/5<br>
                    <?= nl2br(htmlspecialchars($r['comment'])); ?><br>
                    <small><?= substr($r['created_at'], 0, 10); ?></small><br>

                    <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $r['user_id']): ?>
                        <button 
                            type="button"
                            class="btn delete-review"
                            data-id="<?= $r['id']; ?>">
                            Verwijderen
                        </button>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <?php if (isset($_SESSION['user_id'])): ?>
        <h3>Laat een review achter</h3>

        <form id="commentForm">
            <input type="hidden" name="product_id" value="<?= $productId; ?>">

            <label>Rating (1-5):</label><br>
            <input type="number" name="rating" min="1" max="5" required><br><br>

            <label>Comment:</label><br>
            <textarea name="comment" required></textarea><br><br>

            <button type="submit" class="btn">Verstuur</button>
        </form>
    <?php else: ?>
        <p>Je moet <a href="login.php">inloggen</a> om een review te schrijven.</p>
    <?php endif; ?>
</div>

<script>
// REVIEW TOEVOEGEN (AJAX)
document.getElementById('commentForm')?.addEventListener('submit', function(e){
    e.preventDefault();

    let formData = new FormData(this);

    fetch('ajax/rating.php', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            location.reload(); // veilig & simpel
        } else {
            alert('Review toevoegen mislukt');
        }
    });
});

// REVIEW VERWIJDEREN (AJAX)
document.querySelectorAll('.delete-review').forEach(btn => {
    btn.addEventListener('click', function (e) {
        e.preventDefault();

        if (!confirm('Review verwijderen?')) return;

        let reviewId = this.dataset.id;

        fetch('ajax/delete_review.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: 'id=' + reviewId
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                document.getElementById('review-' + reviewId).remove();
            } else {
                alert('Kan review niet verwijderen');
            }
        })
        .catch(() => alert('AJAX fout'));
    });
});
</script>

</body>
</html>
