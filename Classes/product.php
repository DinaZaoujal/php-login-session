<?php

class product{
    private $name;
    private $description;
    private $price;
    private $category_id;
    private $image;

   public function save() {
        $conn = Database::getConnection();
        $stmt = $conn->prepare("
            INSERT INTO products (name, description, price, category_id, image)
            VALUES (:name, :description, :price, :category_id, :image)
        ");
        $stmt->bindValue(":name", $this->name);
        $stmt->bindValue(":description", $this->description);
        $stmt->bindValue(":price", $this->price);
        $stmt->bindValue(":category_id", $this->category_id);
        $stmt->bindValue(":image", $this->image);
        return $stmt->execute();
    }

    public static function getAll() {
        $conn = Database::getConnection();
        $stmt = $conn->query("SELECT * FROM products");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getByCategory($category_id) {
        $conn = Database::getConnection();
        $stmt = $conn->prepare("SELECT * FROM products WHERE category_id = :cat");
        $stmt->bindValue(":cat", $category_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } 
}