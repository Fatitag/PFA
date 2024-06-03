<?php
$host = 'localhost';
$dbname = 'projet_gym';
$username = 'root';
$password = ''; 
$port = 3307; 

$dsn = "mysql:host=$host;dbname=$dbname;port=$port";

try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
