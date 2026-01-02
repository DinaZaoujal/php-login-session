<?php
session_start();
header('Content-Type: application/json');

require_once __DIR__ . '/../Classes/Rating.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Niet ingelogd']);
    exit;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productId = intval($_POST['product_id']);
    $rating = intval($_POST['rating']);
    $comment = trim($_POST['comment']);

    if ($productId <= 0 || $rating <= 0 || empty($comment)) {
        echo json_encode(['success' => false, 'message' => 'Ongeldige gegevens']);
        exit;
    }

    $data = Rating::addReview($productId, $_SESSION['user_id'], $rating, $comment);

    echo json_encode($data);
    exit;
}

echo json_encode(['success' => false, 'message' => 'Ongeldige request']);
