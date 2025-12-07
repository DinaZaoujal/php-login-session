
<?php 
$host = "interchange.proxy.rlwy.net";
$port = 58283;
$dbname = "railway";

$username = "root";
$password = "SdDtiTXBzBFyfKahDLcHHvuaokjCBAVV";

$dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4";

try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "Database connected!";
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
