<?php
session_start();

$pdo = new PDO("mysql:host=localhost;dbname=webshop;charset=utf8mb4", "root", "");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if ($email === "" || $password === "") {
        $error = "Vul een e-mail en wachtwoord in.";
    } else {
        
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        
        $stmt = $pdo->prepare("INSERT INTO user (email, password) VALUES (?, ?)");
        $stmt->execute([$email, $hashedPassword]);

       
        header("Location: login.php");
        exit;
    }
    
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Registreren</title>
</head>
<body>
<h1>Registreren</h1>

<?php if ($error !== ""): ?>
    <p style="color:red;"><?php echo htmlspecialchars($error); ?></p>
<?php endif; ?>

<form method="post">
    <label>E-mail:</label><br>
    <input type="email" name="email" required><br><br>

    <label>Wachtwoord:</label><br>
    <input type="password" name="password" required><br><br>

    <button type="submit">Registreren</button>
</form>

<p>Heb je al een account? <a href="login.php">Login hier</a></p>
</body>
</html>