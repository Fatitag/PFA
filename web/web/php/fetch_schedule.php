<?php
require("../php/log_BD.php");

if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["day"])) {
    $selectedDay = strtolower($_GET["day"]);

    $sql = "SELECT 
    c.libele_cours AS class, 
    c.description_cours,
    tc.libelletype_cours,
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
    LOWER(DAYNAME(s.date_seance)) = '$selectedDay'";

    
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>".$row["class"]."</td>";
            echo "<td>".$row["heure_debut"]." AM - ".$row["heure_fin"]." PM</td>";
            echo "<td>".$row["nom_coach"]." ".$row["prenom_coach"]."</td>";
            echo "<td><a href='php/login.php' style='font-weight: bold; color: orange; text-decoration: none;'>Join</a></td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='4'>No classes available on ".$selectedDay."</td></tr>";
    }
    
    $conn->close();
}
?>