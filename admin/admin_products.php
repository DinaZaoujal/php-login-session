<?php session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['email'] !== 'admin@admin.com') {
    header("Location: ../login.php");
    exit;
}
