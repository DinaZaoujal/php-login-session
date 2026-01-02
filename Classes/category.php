<?php

class Category
{
    public static function getAll(): array
    {
        $conn = Database::getConnection();
        $stmt = $conn->prepare("SELECT * FROM category");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
