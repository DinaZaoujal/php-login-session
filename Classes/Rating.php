<?php
require_once __DIR__ . '/../admin/database.php';

class Rating {

    public static function getByProduct(int $productId): array {
        $conn = Database::getConnection();
        $stmt = $conn->prepare("
            SELECT r.id, r.rating, r.comment, r.created_at, u.email, r.user_id
            FROM rating r
            JOIN users u ON r.user_id = u.id
            WHERE r.product_id = ?
            ORDER BY r.created_at DESC
        ");
        $stmt->execute([$productId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getAverage(int $productId): float {
        $conn = Database::getConnection();
        $stmt = $conn->prepare("SELECT AVG(rating) FROM rating WHERE product_id = ?");
        $stmt->execute([$productId]);
        return round($stmt->fetchColumn(), 1);
    }

    public static function addReview(int $productId, int $userId, int $rating, string $comment): array {
        $conn = Database::getConnection();
        $stmt = $conn->prepare("
            INSERT INTO rating (product_id, user_id, rating, comment)
            VALUES (?, ?, ?, ?)
        ");
        $stmt->execute([$productId, $userId, $rating, $comment]);

        $stmt2 = $conn->prepare("SELECT email FROM users WHERE id = ?");
        $stmt2->execute([$userId]);
        $user = $stmt2->fetch();

        $average = self::getAverage($productId);

        return [
            'id' => $conn->lastInsertId(),
            'email' => $user['email'],
            'rating' => $rating,
            'comment' => nl2br(htmlspecialchars($comment)),
            'created_at' => date('Y-m-d H:i:s'),
            'average' => $average,
            'success' => true
        ];
    }
    public static function deleteReview(int $reviewId, int $userId): array {
        $conn = Database::getConnection();
        $stmt = $conn->prepare("DELETE FROM rating WHERE id = ? AND user_id = ?");
        $success = $stmt->execute([$reviewId, $userId]);
        return ['success' => $success];
    }
}
