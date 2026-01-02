<?php
session_start();
header('Content-Type: application/json');

require_once __DIR__ . '/../Classes/Rating.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Niet ingelogd']);
    exit;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $reviewId = intval($_POST['review_id']);
    $userId = intval($_SESSION['user_id']);

    if ($reviewId <= 0) {
        echo json_encode(['success' => false, 'message' => 'Ongeldige review id']);
        exit;
    }
    $conn = Database::getConnection();
    $stmt = $conn->prepare("SELECT * FROM rating WHERE id = ? AND user_id = ?");
    $stmt->execute([$reviewId, $userId]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$row) {
        echo json_encode(['success' => false, 'message' => 'Review niet gevonden of geen toestemming', 'user_id_session'=>$userId, 'review_user_id'=>$row['user_id'] ?? null]);
        exit;
    }
    $stmt = $conn->prepare("DELETE FROM rating WHERE id = ? AND user_id = ?");
    $success = $stmt->execute([$reviewId, $userId]);

    echo json_encode(['success'=>$success]);
    exit;
}
