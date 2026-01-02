<?php
require_once __DIR__ . '/../admin/Database.php';

class Product {
    private string $name;
    private string $description;
    private float $price;
    private int $category_id;
    private ?string $image;

    public function __construct(string $name = '', string $description = '', float $price = 0.0, int $category_id = 0, ?string $image = null) {
        $this->name = $name;
        $this->description = $description;
        $this->price = $price;
        $this->category_id = $category_id;
        $this->image = $image;
    }

    public function save(): bool {
        $conn = Database::getConnection();
        $stmt = $conn->prepare("
            INSERT INTO product (name, description, price, category_id, image)
            VALUES (:name, :description, :price, :category_id, :image)
        ");
        $stmt->bindValue(":name", $this->name);
        $stmt->bindValue(":description", $this->description);
        $stmt->bindValue(":price", $this->price);
        $stmt->bindValue(":category_id", $this->category_id);
        $stmt->bindValue(":image", $this->image);
        return $stmt->execute();
    }

    public static function getAll(): array {
        $conn = Database::getConnection();
        $stmt = $conn->query("SELECT * FROM product");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getByCategory(int $category_id): array {
        $conn = Database::getConnection();
        $stmt = $conn->prepare("SELECT * FROM product WHERE category_id = :cat");
        $stmt->bindValue(":cat", $category_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getById(int $id): ?array {
        $conn = Database::getConnection();
        $stmt = $conn->prepare("SELECT * FROM product WHERE id = :id");
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ?: null;
    }
}
