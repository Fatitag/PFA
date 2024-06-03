<?php
session_start();

if (!isset($_SESSION['loggedin'])) {
    header('Location: ../index.php');
    exit;
}
require("../php/log_BD.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_seance = $_POST['id_seance'];
    $id_adherent = $_POST['id_adherent'];

    $stmt = $pdo->prepare("DELETE FROM inscriptionseance WHERE id_seance = ? AND id_adherent = ?");
    $stmt->bindParam(1, $id_seance, PDO::PARAM_INT);
    $stmt->bindParam(2, $id_adherent, PDO::PARAM_INT);

    if ($stmt->execute()) {
        header("Location: ../adherent/planning.php");
    } else {
        //echo "Error: " . $stmt->error;
        header("Location: ../web/error.html");
    }

    $stmt->closeCursor();
    $pdo = null; 
} else {
    header("Location: ../adherent/planning.php");
    exit;
}
?>

