<?php

require("../php/log_BD.php"); 

if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["day"])) {
    $selectedDay = strtolower($_GET["day"]);

    $sql = "SELECT 
                c.libele_cours AS class, 
                c.description_cours,
                tc.libelletype_cours,
                s.id_seance,
                s.date_seance,
                s.heure_debut,
                s.heure_fin,
                co.nom_coach, 
                co.prenom_coach
            FROM 
                cours c
            JOIN 
                seance s ON c.id_cours = s.id_cours
            JOIN 
                coach co ON s.id_coach = co.id_coach
            JOIN 
                type_cours tc ON c.id_type_cours = tc.id_type_cours
            WHERE 
                LOWER(DAYNAME(s.date_seance)) = :selectedDay";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':selectedDay', $selectedDay, PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetchAll();

    if (count($result) > 0) {
        foreach ($result as $row) {
            echo "<tr>";
            echo "<td>".$row["class"]."</td>";
            echo "<td>".$row["heure_debut"]." AM - ".$row["heure_fin"]." PM</td>";
            echo "<td>".$row["nom_coach"]." ".$row["prenom_coach"]."</td>";
            echo "<td><a href='../adherent/join.php?seance_id=".$row["id_seance"]."&day=".$selectedDay."'>Join</a></td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='4'>Aucune classe disponible ".$selectedDay."</td></tr>";
    }

    $pdo = null; 
}
?>
