<?php
session_start();

if (!isset($_SESSION['loggedin']) || !isset($_SESSION['id_adherent'])) {
    // echo "Session not set properly!";
    header("Location: ../error.html");

    exit;
}

require("../php/log_BD.php");

if (isset($_GET['seance_id'])) {
    $seance_id = $_GET['seance_id']; 
    $id_adherent = $_SESSION['id_adherent'];

    $stmt_check = $pdo->prepare("SELECT COUNT(*) FROM inscriptionseance WHERE id_adherent = ? AND id_seance = ?");
    $stmt_check->execute([$id_adherent, $seance_id]);
    $count = $stmt_check->fetchColumn();

    if ($count > 0) {
        header("Location: ../adherent/planning.php?error=already_enrolled");
        exit;
    }
    $sql = "INSERT INTO inscriptionseance (id_adherent, id_seance) VALUES (?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(1, $id_adherent, PDO::PARAM_INT);
    $stmt->bindParam(2, $seance_id, PDO::PARAM_INT);
    $stmt->execute();

    header('Location: ../adherent/planning.php');
    exit;
} else {
    echo "Parameters not set properly!";
    exit;
}
?>
