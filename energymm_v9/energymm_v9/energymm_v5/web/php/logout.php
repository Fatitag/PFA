<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("location: ../php/login.php");
    exit;
}

$_SESSION = array();

session_destroy();

header("location: ../php/login.php");
exit;
?>