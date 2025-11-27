<?php // login.php 

//session_start();
//if (!empty($_SESSION))
function canLogin($p_email , $p_password){
$conn = new PDO('mysql:host=localhost;dbname=`php webshop`', "root", "");
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$statement=$conn->prepare("SELECT*FROM user WHERE email=:email");

$statement->execute();

$user=$statement->fetch(PDO::FETCH_ASSOC);
if (password_verify($p_password,$user['password'])){
    return true;

}else{
    return false;
}
}

if (!empty($_POST)){
    $email=$_POST['email'];
    $password=$_POST['password'];

    if(canLogin($email,$password)){
        $salt="342334535DFE3ZTD5";
        $cookieVal=$email . ",". md5($email.$salt);
        setcookie("loggedin",$cookieVal, time()+60*60*24*30,"/","",true,true);
        
        header('Location: index.php');
        exit;

    }else{
        $error= "Sorry, we can't log in with that email adress and password. Can you try again?";
    }
}
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>
</head>
<body>
 <h1>log-in</h1>
 <?php if (isset($error)): ?>
<p style="color:red;"><?php echo ($error); ?></p>
<?php endif; ?>
<div class="form_field">
<form method="post">
<label>E-mail:</label><br>
<input type="email" name="email" required><br><br>

<label>Wachtwoord:</label><br>
<input type="password" name="password" required><br><br>
<button type="submit">inloggen</button>

</form>
<p>geen account?<a href="register.php">Registreer hier</a></p>
</div>
</form>  

</body>
</html>
