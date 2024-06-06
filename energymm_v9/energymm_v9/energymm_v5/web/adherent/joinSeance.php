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
        $response = array("status" => "error", "message" => "Vous êtes déjà inscrit à une autre session à ce moment-là.");
        echo json_encode($response);
        exit;
    }

    // If user is not enrolled in another session, proceed to enroll them in the session
    $pdo->beginTransaction(); 

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
            $pdo->commit();
            $response = array("status" => "success", "message" => "Session rejointe avec succès.");
            echo json_encode($response);
        } else {
            // If there's an error updating the session, rollback the transaction
            $pdo->rollBack();
            $response = array("status" => "error", "message" => "Erreur lors de la connexion à la session. Veuillez réessayer plus tard.");
            header("Location: ../web/error.php");
            exit;
            // echo json_encode($response);
        }
    } else {
        // If there's an error enrolling the user, return an error message
        $pdo->rollBack();
        $response = array("status" => "error", "message" => "Erreur lors de la connexion à la session. Veuillez réessayer plus tard.");
        echo json_encode($response);
    }
//cleaning
    $stmt_insert = null;
    $stmt_update = null;
    $stmt_check = null; 
    $pdo = null; 
} else {
    // If the request method is not POST, return an error message
    $response = array("status" => "error", "message" => "Méthode de demande invalide.");
    echo json_encode($response);
    exit;
}
?>
