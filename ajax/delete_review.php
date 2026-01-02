<?php
session_start();
header('Content-Type: application/json');

require_once __DIR__ . '/../admin/database.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Niet ingelogd']);
    exit;
}
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Ongeldige request']);
    exit;
}
$reviewId = intval($_POST['id'] ?? 0);
$userId   = intval($_SESSION['user_id']);

if ($reviewId <= 0) {
    echo json_encode(['success' => false, 'message' => 'Ongeldige review id']);
    exit;
}

try {
    $conn = Database::getConnection();
    $stmt = $conn->prepare(
        "SELECT id FROM rating WHERE id = ? AND user_id = ?"
    );
    $stmt->execute([$reviewId, $userId]);
    $review = $stmt->fetch();

    if (!$review) {
        echo json_encode([
            'success' => false,
            'message' => 'Geen rechten om deze review te verwijderen'
        ]);
        exit;
    }
    $stmt = $conn->prepare(
        "DELETE FROM rating WHERE id = ? AND user_id = ?"
    );
    $stmt->execute([$reviewId, $userId]);

    echo json_encode(['success' => true]);
    exit;

} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Server fout']);
    exit;
}
