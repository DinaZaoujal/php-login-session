<?php
session_start();

$pdo = new PDO(
    "mysql:host=localhost;dbname=webshop;charset=utf8mb4",
    "root",
    ""
);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = strtolower(trim($_POST['email'] ?? ""));
    $password = trim($_POST['password'] ?? "");

    if ($email === "" || $password === "") {
        $error = "Vul een e-mail en wachtwoord in.";
    } else {

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        try {
            $stmt = $pdo->prepare(
                "INSERT INTO users (email, password, balance) VALUES (?, ?, 100)"
            );
            $stmt->execute([$email, $hashedPassword]);

            header("Location: login.php");
            exit;

        } catch (PDOException $e) {
            if ($e->getCode() == 23000) {
                $error = "Dit e-mailadres is al geregistreerd.";
            } else {
                $error = "Er ging iets mis. Probeer later opnieuw.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Registreren</title>
    <link rel="stylesheet" href="Css/normalize.css">
    <link rel="stylesheet" href="Css/register.css">
</head>
<body>

<div class="login-container">
    <h1>Registreren</h1>

    <?php if ($error !== ""): ?>
        <div class="error"><?= htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <form method="post">
        <label>E-mail</label>
        <input type="email" name="email" required>

        <label>Wachtwoord</label>
        <input type="password" name="password" required>

        <button type="submit">Account aanmaken</button>
    </form>

    <p>Heb je al een account?
        <a href="login.php">Login hier</a>
    </p>
</div>

</body>
</html>
