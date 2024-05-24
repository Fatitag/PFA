<?php
session_start();

if (!isset($_SESSION['loggedin']) || !isset($_SESSION['id_adherent'])) {
    echo "Session not set properly!";
    exit;
}

require("../php/log_BD.php");

if(isset($_GET['seance_id'])) {
    $seance_id = $_GET['seance_id']; 
    $id_adherent = $_SESSION['id_adherent'];

    $sql = "INSERT INTO inscriptionseance (id_adherent, id_seance) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $id_adherent, $seance_id);
    $stmt->execute();

    header('Location: ../adherent/planning.php');
    exit;
} else {
    echo "Parameters not set properly!";
    exit;
}
if(isset($_GET['seance_id']) && isset($_SESSION['id_adherent'])) {
    $seance_id = $_GET['seance_id']; 
    $id_adherent = $_SESSION['id_adherent'];

    if($id_adherent !== null) {
        $sql = "INSERT INTO inscriptionseance (id_adherent, id_seance) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $id_adherent, $seance_id);

        if ($stmt->execute()) {
            header('Location: ../adherent/planning.php');
            exit;
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
            exit;
        }
    } else {
        echo "Error: id_adherent is null.";
        exit;
    }
} else {
    echo "Parameters not set properly!";
    exit;
}

?>
<html>
    <head>
    <link rel="stylesheet" href="../css/planning.css">
    <link rel="stylesheet" href="../css/dashboard.css">
    </head>
</html>
