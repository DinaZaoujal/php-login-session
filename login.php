<?php // login.php 

session_start();
if (!empty($_SESSION))

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>
</head>
<body>
 <h1>log-in</h1>
 <?php if (!empty($error)): ?>
<p style="color:red;"><?php echo ($error); ?></p>
<?php endif; ?>
<form method="post">
<label>E-mail:</label><br>
<input type="email" name="email" required><br><br>

<label>Wachtwoord:</label><br>
<input type="password" name="password" required><br><br>
<button type="submit">inloggen</button>

</form>
<p>geen account?<a href="register.php">Registreer hier</a></p>
</form>   
</body>
</html>
