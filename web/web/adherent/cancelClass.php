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

    $stmt = $conn->prepare("DELETE FROM inscriptionseance WHERE id_seance = ? AND id_adherent = ?");
    $stmt->bind_param("ii", $id_seance, $id_adherent);

    if ($stmt->execute()) {
        header("Location: ../adherent/planning.php");
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    header("Location: ../adherent/planning.php");
    exit;
}
?>
