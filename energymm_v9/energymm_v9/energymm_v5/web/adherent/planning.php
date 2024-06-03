<?php
session_start();

if (!isset($_SESSION['loggedin'])) {
    header('Location: ../index.php');
    exit;
}
require("../php/log_BD.php");
$ida = $_SESSION['id_adherent'];

?>
<?php

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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.7.0/font/bootstrap-icons.min.css">
    <!-- <link rel="stylesheet" href="../css/planning.css"> -->
    <link rel="stylesheet" href="../css/dashboard.css">
    <style>
        body, content {
            font-family: Arial, sans-serif;
            text-align: center;
            text-decoration: none;
            border: none;
            padding: 0;
            margin: 0;
            color: black;
            box-sizing: border-box;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        td, th {
            border: 1px solid #000000;
            padding: 4px;
        }

        tr:nth-child(even) {
            background-color: #dddddd;
        }

        .days-navigation {
            display: flex;
            justify-content: space-around;
            /* margin-bottom: 2rem; */
        }

        .day-nav {
            margin: 0 10px;
        }

        .btn {
            background-color: transparent;
            padding: 10px 10px;
            display: inline-block;
            font-size: 16px;
            cursor: pointer;
            justify-content: space-between;
            border-radius: 5px;
            border: none;
        }

        .btn:hover, .btn.clicked {
            background-color: orange;
        }

        .join-btn {
            background-color: #bf9032;
            color: white;
            padding: 8px 16px;
            cursor: pointer;
        }

        h2 {
            text-decoration-line: underline orange;
            text-align: center;
            text-decoration: underline orange !important;
        }

        #message {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #DAD3BE;
            color: #721c24;
            padding: 20px;
            border: 1px solid #f5c6cb;
            border-radius: 5px;
            z-index: 9999;
            text-align: center;
        }

        .close-btn {
            background-color: #EEEEEE;
            border: none;
            color: #721c24;
            padding: 5px 10px;
            cursor: pointer;
            font-size: 16px;
            border-radius: 3px;
            margin-top: 10px;
        }

        .close-btn:hover {
            background-color: #EEEEEE;
        }

        .menu-items {
            color: white;
        }
    </style>

</head>
<body>
<?php include_once("../adherent/sidebar.php"); ?>
<div class="content">
    <div class="container mb-5" id="planning">
        <h2 class="text-center mb-5">Planning Join</h2> <br>
        <div class="days-navigation">
            <button type="button" class="btn" onclick="loadSchedule('monday')">Monday</button>
            <button type="button" class="btn" onclick="loadSchedule('tuesday')">Tuesday</button>
            <button type="button" class="btn" onclick="loadSchedule('wednesday')">Wednesday</button>
            <button type="button" class="btn" onclick="loadSchedule('thursday')">Thursday</button>
            <button type="button" class="btn" onclick="loadSchedule('friday')">Friday</button>
            <button type="button" class="btn" onclick="loadSchedule('saturday')">Saturday</button>
            <button type="button" class="btn" onclick="loadSchedule('sunday')">Sunday</button>
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
        <h2 class="text-center mb-5">Joined Classes</h2> <br>
        <div id="message" style="display: none;">
            <?php
            if (isset($_GET['error']) && $_GET['error'] == 'already_enrolled') {
                echo "You are already enrolled in this session.";
            }
            ?>
            <br>
            <button class="close-btn" onclick="closeMessage()">Close</button>
        </div>
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

                    $stmt = $pdo->prepare($sql);
                    $stmt->bindParam(1, $ida, PDO::PARAM_INT);
                    $stmt->execute();
                    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    if (count($result) > 0) {
                        foreach ($result as $row) {
                            echo "<tr>";
                            echo "<td>".$row["date_seance"]."</td>";
                            echo "<td>".$row["nom_coach"]." ".$row["prenom_coach"]."</td>";
                            echo "<td>".$row["libele_cours"]."</td>";
                            echo "<td>".$row["libelletype_cours"]."</td>";
                            echo "<td>".$row["heure_debut"]." - ".$row["heure_fin"]."</td>";
                            echo "<td>
                            <form method='POST' action='cancelClass.php'>
                                <input type='hidden' name='id_seance' value='".$row["id_seance"]."'>
                                <input type='hidden' name='id_adherent' value='".$ida."'>
                                <button type='submit' class='btn btn-danger'>Cancel</button>
                            </form>
                            </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>No joined classes available.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    window.onload = function() {
        var messageDiv = document.getElementById('message');
        if (messageDiv.innerHTML.trim() !== '') {
            messageDiv.style.display = 'block';
        }
    };

    function closeMessage() {
        var messageDiv = document.getElementById('message');
        messageDiv.style.display = 'none';
    }

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
<script src="js/script.js"></script>
</body>
</html>
