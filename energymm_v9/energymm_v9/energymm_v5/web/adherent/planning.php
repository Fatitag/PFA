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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.7.0/font/bootstrap-icons.min.css">
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
            margin-bottom: 20px;
            flex-wrap: nowrap; 
            overflow-x: auto; 
            -webkit-overflow-scrolling: touch; 
            scrollbar-width: none; 
            -ms-overflow-style: none; 
        }

        .days-navigation::-webkit-scrollbar {
            display: none; 
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
            margin: 5px;
        }

        .btn:hover {
            background-color: orange;
        }

        .btn.active {
            background-color: #ff7f00;
            color: white;
        }

        .join-btn {
            background-color: #28a745;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            transition: background-color 0.3s ease;
        }

        .join-btn:hover {
            background-color: #218838;
        }

        .join-btn:active {
            background-color: #1e7e34;
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
            background-color: #DDDDDD;
        }

        .menu-items {
            color: white;
        }

        .error-message {
            background-color: #f8d7da;
            border-color: #f5c6cb;
            color: #721c24;
            width: 80%;
            max-width: 500px;
            padding: 20px;
            border-radius: 5px;
            margin: 20px auto;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        @media screen and (max-width: 768px) {
            .table-responsive table {
                display: block;
                overflow-x: auto;
                white-space: nowrap;
            }

            .table-responsive th, .table-responsive td {
                white-space: nowrap;
                padding: 8px 16px;
            }

            .btn {
                margin: 5px 0;
                width: 90%;
            }

            #message {
                width: 90%;
                max-width: 400px;
            }

            .container {
                padding: 0 10px;
            }
        }
    </style>
</head>
<body>
<?php include_once("../adherent/sidebar.php"); ?>
<script>
    var contentDiv = document.getElementById('planning');
    contentDiv.style.backgroundColor = '#ff7f00';
</script>

<div class="content">
    <div class="container mb-5" id="planning">
        <h2 class="text-center mb-5">Planification</h2> <br>
        <div class="days-navigation">
            <button type="button" class="btn" onclick="loadSchedule('monday', this)">Lundi</button>
            <button type="button" class="btn" onclick="loadSchedule('tuesday', this)">Mardi</button>
            <button type="button" class="btn" onclick="loadSchedule('wednesday', this)">Mercredi</button>
            <button type="button" class="btn" onclick="loadSchedule('thursday', this)">Jeudi</button>
            <button type="button" class="btn" onclick="loadSchedule('friday', this)">Vendredi</button>
            <button type="button" class="btn" onclick="loadSchedule('saturday', this)">Samedi</button>
            <button type="button" class="btn" onclick="loadSchedule('sunday', this)">Dimanche</button>
        </div>
        <div id="error-message" class="error-message" style="display: <?php echo isset($_GET['error']) ? 'block' : 'none'; ?>;">
            <?php
            if (isset($_GET['error']) && $_GET['error'] == 'already_enrolled') {
                echo "You are already enrolled in this session.";
            }
            ?>
            <br>
            <button class="close-btn" onclick="closeMessage()">fermer</button>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th scope="col">Classe</th>
                        <th scope="col">Temps</th>
                        <th scope="col">Coach</th>
                        <th scope="col">Rejoignez-nous</th>
                    </tr>
                </thead>
                <tbody id="schedule-body">
                </tbody>
            </table>
        </div>
    </div><br>

    <div class="container mb-5" id="planning">
        <h2 class="text-center mb-5">Cours rejoints</h2> <br>
        <div id="message">
            <span id="message-text"></span>
            <br>
            <button class="close-btn" onclick="closeMessage()">fermer</button>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th scope="col">Jour</th>
                        <th scope="col">Coach</th>
                        <th scope="col">Cours</th>
                        <th scope="col">Type de cours</th>
                        <th scope="col">Heure</th>
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
                        echo "<tr><td colspan='6'>Aucun cours rejoint disponible.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <div id="error-message" class="error-message" style="display: none;"></div>

</div>

<script>
    function loadSchedule(day, btn) {
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
                document.getElementById("schedule-body").innerHTML = this.responseText;

                // Remove 'active' class from all buttons
                var buttons = document.querySelectorAll('.btn');
                buttons.forEach(function(button) {
                    button.classList.remove('active');
                });

                // Add 'active' class to the clicked button
                btn.classList.add('active');
            }
        };
        xhr.open("GET", "../adherent/fetch_second_table.php?day=" + day, true);
        xhr.send();
    }

    function joinSession(sessionId) {
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
                var response = JSON.parse(this.responseText);
                var messageDiv = document.getElementById('error-message');
                if (response.status === 'error') {
                    messageDiv.innerText = response.message;
                    messageDiv.style.display = 'block';
                    messageDiv.classList.add('error-message');
                } else {
                    loadSchedule(currentDay); 
                }
            }
        };
        xhr.open("POST", "../adherent/joinSeance.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        var params = "session_id=" + sessionId;
        xhr.send(params);
    }

    function closeMessage() {
        var errorMessage = document.getElementById('error-message');
        errorMessage.style.display = 'none';
    }
</script>

</body>
</html>
