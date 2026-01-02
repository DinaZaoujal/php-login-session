<?php
session_start();
//var_dump($_POST);

function canLogin($email, $password) {
    try {
        $conn = new PDO("mysql:host=localhost;dbname=webshop;charset=utf8mb4", "root", "");
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("SELECT * FROM `users` WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            return false;
        }

        if (password_verify($password, $user['password'])) {
            return $user; 
        } else {
            return false;
        }

    } catch (PDOException $e) {
        echo "Database fout: " . $e->getMessage();
        return false;
    }
}


if (!empty($_POST)) {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $user = canLogin($email, $password); 

    if ($user) {
        $_SESSION['logged_in'] = true;
        $_SESSION['email'] = $email;
        $_SESSION['user_id'] = $user['id'];
        header("Location: index.php");
        exit;
    } else {
        $error = "E-mail of wachtwoord is fout.";
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>login</title>
    <link rel="stylesheet" href="login.css">

</head>
<body>
<div class="login-container">
    <h1>Log in</h1>

    <?php if (isset($error)): ?>
        <div class="error"><?php echo $error; ?></div>
    <?php endif; ?>

    <form method="post">
        <label>E-mail</label>
        <input type="email" name="email" required>

        <label>Wachtwoord</label>
        <input type="password" name="password" required>

        <button type="submit">Inloggen</button>
    </form>

    <p>Geen account? <a href="register.php">Registreer hier</a></p>
</div>

</body>
</html>
