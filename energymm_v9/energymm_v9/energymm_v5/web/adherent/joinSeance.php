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

    // Check if the user is already enrolled in another session at the same time
    $sql_check = "SELECT id_seance FROM inscriptionseance WHERE id_adherent = ? AND id_seance IN (
                    SELECT id_seance FROM seance WHERE id_seance = ? AND NOW() BETWEEN heure_debut AND heure_fin
                  )";
    $stmt_check = $pdo->prepare($sql_check);
    $stmt_check->bindParam(1, $ida, PDO::PARAM_INT);
    $stmt_check->bindParam(2, $session_id, PDO::PARAM_INT);
    $stmt_check->execute();
    $result_check = $stmt_check->fetchAll();

    if (count($result_check) > 0) {
        // If user is already enrolled in another session at the same time, return an error message
        $response = array("status" => "error", "message" => "You are already enrolled in another session at this time.");
        echo json_encode($response);
        exit;
    }

    // If user is not enrolled in another session, proceed to enroll them in the session
    $pdo->beginTransaction(); // Start a transaction

    $sql_insert = "INSERT INTO inscriptionseance (id_adherent, id_seance) VALUES (?, ?)";
    $stmt_insert = $pdo->prepare($sql_insert);
    $stmt_insert->bindParam(1, $ida, PDO::PARAM_INT);
    $stmt_insert->bindParam(2, $session_id, PDO::PARAM_INT);
    if ($stmt_insert->execute()) {
        // If user is successfully enrolled, update the number of adherents in the session table
        $sql_update = "UPDATE seance SET nbr_adherent = nbr_adherent + 1 WHERE id_seance = ?";
        $stmt_update = $pdo->prepare($sql_update);
        $stmt_update->bindParam(1, $session_id, PDO::PARAM_INT);
        if ($stmt_update->execute()) {
            // If the update is successful, commit the transaction
            $pdo->commit();
            $response = array("status" => "success", "message" => "Session joined successfully.");
            echo json_encode($response);
        } else {
            // If there's an error updating the session, rollback the transaction
            $pdo->rollBack();
            $response = array("status" => "error", "message" => "Error joining session. Please try again later.");
            echo json_encode($response);
        }
    } else {
        // If there's an error enrolling the user, return an error message
        $pdo->rollBack();
        $response = array("status" => "error", "message" => "Error joining session. Please try again later.");
        echo json_encode($response);
    }

    // Clean up
    $stmt_insert = null;
    $stmt_update = null;
    $stmt_check = null; 
    $pdo = null; 
} else {
    // If the request method is not POST, redirect to an error page
    header('Location: ../error.html');
    exit;
}
?>
