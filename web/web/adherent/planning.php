<?php
session_start();

if (!isset($_SESSION['loggedin'])) {
    header('Location: ../index.php');
    exit;
}
require("../php/log_BD.php");
$ida = $_SESSION['id_adherent'];

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenue</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.7.0/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/planning.css">
    <link rel="stylesheet" href="../css/dashboard.css">
</head>
<body>
<?php include_once("../adherent/sidebar.php"); ?>
<div class="content">
<div class="container mb-5" id="planning">
  <h2 class="text-center mb-5">Planning Join</h2>
  <div class="days-navigation mb-3">
  <button type="button" class="btn btn-outline-dark" onclick="loadSchedule('monday')">Monday</button>
  <button type="button" class="btn btn-outline-dark" onclick="loadSchedule('tuesday')">Tuesday</button>
  <button type="button" class="btn btn-outline-dark" onclick="loadSchedule('wednesday')">Wednesday</button>
  <button type="button" class="btn btn-outline-dark" onclick="loadSchedule('thursday')">Thursday</button>
  <button type="button" class="btn btn-outline-dark" onclick="loadSchedule('friday')">Friday</button>
  <button type="button" class="btn btn-outline-dark" onclick="loadSchedule('saturday')">Saturday</button>
  <button type="button" class="btn btn-outline-dark" onclick="loadSchedule('sunday')">Sunday</button>
  </div>
  <div class="table-responsive">
    <table class="table table-bordered">
      <thead>
        <tr>
          <th scope="col">Classe</th>
          <th scope="col">Temps</th>
          <th scope="col">Coach</th>
          <th scope="col">Join us</th>
        </tr>
      </thead>
      <tbody id="schedule-body">
      </tbody>
    </table>
  </div>
</div><br>

<div class="container mb-5" id="planning">
    <h2 class="text-center mb-5">Joined Classes</h2>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th scope="col">Day</th>
                    <th scope="col">Coach</th>
                    <th scope="col">Cours</th>
                    <th scope="col">Type cours</th>
                    <th scope="col">Time</th>
                    <th scope="col">Action</th>

                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT 
                i.id_seance,
                s.date_seance,
                co.nom_coach, 
                co.prenom_coach,
                c.libele_cours,
                tc.libelletype_cours,
                s.heure_debut,
                s.heure_fin
            FROM 
                inscriptionseance i
            JOIN 
                seance s ON i.id_seance = s.id_seance
            JOIN 
                coach co ON s.id_coach = co.id_coach
            JOIN 
                cours c ON s.id_cours = c.id_cours
            JOIN 
                type_cours tc ON c.id_type_cours = tc.id_type_cours
            WHERE 
                i.id_adherent = ?";
    

                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $ida);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>".$row["date_seance"]."</td>";
                        echo "<td>".$row["nom_coach"]." ".$row["prenom_coach"]."</td>";
                        echo "<td>".$row["libele_cours"]."</td>";
                        echo "<td>".$row["libelletype_cours"]."</td>";
                        echo "<td>".$row["heure_debut"]." - ".$row["heure_fin"]."</td>";
                        echo "<td>
                        <form method='POST' action='cancelClass.php'>
                            <input type='hidden' name='id_seance' value='".$row["id_seance"]."'> <!-- Add this line -->
                            <input type='hidden' name='id_adherent' value='".$ida."'>
                            <button type='submit' class='btn btn-danger'>Cancel</button>
                        </form>
                      </td>";
                        echo "</tr>";
        }
                } else {
                    echo "<tr><td colspan='6'>No joined classes available.</td></tr>";
                }
                $stmt->close();
                $conn->close();
                ?>
                            

            </tbody>
        </table>
    </div>
</div>

<script src="js/script.js"></script>
<script>
function loadSchedule(day) {
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
            document.getElementById("schedule-body").innerHTML = this.responseText;
        }
    };
    xhr.open("GET", "../adherent/fetch_second_table.php?day=" + day, true); 
    xhr.send();
}
</script>
</body>
</html>
