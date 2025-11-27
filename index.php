<?php // index.php 
include_once(__DIR__."/data.inc.php");

$cookie=$_COOKIE['loggedin']?? null;
$salt="342334535DFE3ZTD5";
if(!$cookie){
    header("location: login.php");
    exit;
}
$frags = explode(",",$cookie);

if(!isset($frags[1])||$frags[1]!==md5($frags[0].$salt)){
    header("location:login.php");
    exit;
}
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TechGadgets</title>
</head>
<body>
    
</body>
</html>
