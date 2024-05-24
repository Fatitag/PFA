<?php
session_start();

if (!isset($_SESSION['loggedin'])) {
    header('Location: ../index.php');
    exit;
}

require("../php/log_BD.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $session_id = $_POST['session_id'];
    $ida = $_SESSION['id_adherent'];

    $sql_check = "SELECT id_seance FROM inscriptionseance WHERE id_adherent = ? AND id_seance IN (
                    SELECT id_seance FROM seance WHERE id_seance = ? AND NOW() BETWEEN heure_debut AND heure_fin
                  )";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param("ii", $ida, $session_id);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    if ($result_check->num_rows > 0) {
        $response = array("status" => "error", "message" => "You are already enrolled in another session at this time.");
        echo json_encode($response);
        exit;
    }

    $sql_insert = "INSERT INTO inscriptionseance (id_adherent, id_seance) VALUES (?, ?)";
    $stmt_insert = $conn->prepare($sql_insert);
    $stmt_insert->bind_param("ii", $ida, $session_id);
    if ($stmt_insert->execute()) {
        $response = array("status" => "success", "message" => "Session joined successfully.");
        echo json_encode($response);
    } else {
        $response = array("status" => "error", "message" => "Error joining session. Please try again later.");
        echo json_encode($response);
    }

    $stmt_insert->close();
    $stmt_check->close();
    $conn->close();
} else {
    header('Location: ../error.php');
    exit;
}
?>
