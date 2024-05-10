<?php
require("../php/log_BD.php");

if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["day"])) {
    $selectedDay = strtolower($_GET["day"]);

    $sql = "SELECT c.libelle AS class, c.heure_debut, c.heure_fin, co.nom_coach, co.prenom_coach
            FROM cours c
            JOIN coach co ON c.id_coach = co.id_coach
            WHERE LOWER(DAYNAME(c.date_debut)) = '$selectedDay'";
    
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

//echo "Fetching schedule for day: $selectedDay";
?>
