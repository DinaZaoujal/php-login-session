<?php

class Database {
    private static $conn;

    public static function getConnection() {
        if (self::$conn === null) {
            //self::$conn = new PDO("mysql:host=127.0.0.1;dbname=webshop;charset=utf8", "root", "123456");
            self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        return self::$conn;
    }
}
