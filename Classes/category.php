<?php

require_once "admin/Database.php";

class Category
{
    public static function getAll(): array
    {
        $conn = Database::getConnection();
        $stmt = $conn->prepare("SELECT * FROM category ORDER BY name");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
