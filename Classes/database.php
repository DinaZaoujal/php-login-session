<?php

class Database {

    private static $conn = null;

    public static function getConnection() {
        if (self::$conn === null) {
            self::$conn = new PDO(
                "mysql:host=127.0.0.1;dbname=webshop;charset=utf8mb4",
                "root",
                "" // XAMPP default
            );
            self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        return self::$conn;
    }
}
