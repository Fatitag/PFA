<?php
session_start();

if (!isset($_SESSION['loggedin'])) {
    header('Location: ../index.php');
    exit;
}
require("../php/log_BD.php");

if (!isset($_GET['id'])) {
    header('Location: error.php');
    exit;
}

$coach_id = $_GET['id'];
$sql = "SELECT nom_coach, about_coach FROM coach WHERE id_coach = ?";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(1, $coach_id, PDO::PARAM_INT);
$stmt->execute();
$result = $stmt->fetchAll();

if (count($result) === 1) {
    $coach = $result[0];
} else {
    header('Location: error.php');
    exit;
}

$sql = "SELECT id_seance, date_seance, heure_debut, heure_fin, nbr_adherent FROM seance WHERE id_coach = ?";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(1, $coach_id, PDO::PARAM_INT);
$stmt->execute();
$result = $stmt->fetchAll();

$sessions = [];
if (count($result) > 0) {
    $sessions = $result;
}
$pdo = null;
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coach Details</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.7.0/font/bootstrap-icons.css" rel="stylesheet">
    

   <style>* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Arial', sans-serif;
}

body {
    background-color: #ffffff;
}

.navbar {
    background-color: #000000;
    color: #ffffff;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 30px 20px;
    height: 30px;
}

.navbar .logo {
    font-size: 24px;
    font-weight: bold;
}

 .navbar .search-notification {
    display: flex;
    align-items: center;
}

.navbar input[type="search"] {
    padding: 5px;
    margin-right: 10px;
}

.navbar .notification {
    margin-right: 10px;
}

.sidebar {
    width: 220px;
    background-color: #000000;
    color: #ffffff;
    height: 100vh;
    position: fixed;
    top: 0;
    left: 0;
    padding: 20px;
    display: flex;
    flex-direction: column;
    align-items: center; 
}

.sidebar img {
    margin-bottom: 20px; 
}

.sidebar a {
    color: #ffffff;
    text-decoration: none;
    display: block;
    margin-bottom: 20px;
    text-align: center;
    padding: 10px 0;
    transition: background-color 0.3s, color 0.3s; 
    width: 100%; 
}

.sidebar a:hover {
    background-color: #ff7f00; 
    color: #000000; 
}

.content {
    margin-left: 250px;
    padding: 20px;
    color: black;
}

.content p {
    color: #000000;
}

.sidebar {
    display: flex;
    flex-direction: column;
    align-items: center;
}

.menu-items {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
}

.menu-item {
    display: flex;
    align-items: center;
    text-decoration: none;
    color: white;
    margin: 5px;
}

.menu-item i {
    margin-right: 5px;
}
* {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Arial', sans-serif;
        }

        body {
            background-color: #ffffff;
        }

        .navbar {
            background-color: #000000;
            color: #ffffff;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 30px 20px;
            height: 30px;
        }

        .navbar .logo {
            font-size: 24px;
            font-weight: bold;
        }

        .navbar .search-notification {
            display: flex;
            align-items: center;
        }

        .navbar input[type="search"] {
            padding: 5px;
            margin-right: 10px;
        }

        .navbar .notification {
            margin-right: 10px;
        }

        .sidebar {
            width: 220px;
            background-color: #000000;
            color: #ffffff;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .sidebar img {
            margin-bottom: 20px;
        }

        .sidebar a {
            color: #ffffff;
            text-decoration: none;
            display: block;
            margin-bottom: 20px;
            text-align: center;
            padding: 10px 0;
            transition: background-color 0.3s, color 0.3s;
            width: 100%;
        }

        .sidebar a:hover {
            background-color: #ff7f00;
            color: #000000;
        }

        .content {
            margin-left: 250px;
            padding: 20px;
            color: black;
        }

        .content p {
            color: #000000;
        }

        .coach-details {
            text-align: center;
            margin-bottom: 20px;
        }

        .sessions {
            text-align: center;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin-bottom: 20px;
        }

        th, td {
            border: 1px solid #000000;
            padding: 8px;
        }

        th {
            background-color: #ff7f00;
            color: white;
        }

        .join-session {
            background-color: #ff7f00;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
        }

        .join-session:hover {
            background-color: orange;
        }

        .back-button {
            color: orange;
            text-decoration: none;
            margin-bottom: 20px;
            display: inline-block;
        }

        .back-button:hover {
            text-decoration: underline;
        }
        h3{
            text-decoration:underline orange;
        }
</style>
</head>
<body>

<?php include_once("../adherent/sidebar.php"); ?>

<div class="content">
<a href="../adherent/chooseCoach.php" class="back-button"><i class="fas fa-arrow-left"></i> Back</a> 

    <div class="coach-details">
        <h2><?php echo htmlspecialchars($coach['nom_coach']); ?></h2>
        <p><?php echo nl2br(htmlspecialchars($coach['about_coach'])); ?></p>
    </div>
    <!-- <button onclick="goBack()">Back</button> -->
    <div class="sessions">
        <h3>Available Sessions</h3><br>
        <table>
            <tr>
                <th>Date</th>
                <th>Start Time</th>
                <th>End Time</th>
                <th>Number of Adherents</th>
                <th>Action</th>
            </tr>
            <?php foreach ($sessions as $session): ?>
                <tr>
                    <td><?php echo htmlspecialchars($session['date_seance']); ?></td>
                    <td><?php echo htmlspecialchars($session['heure_debut']); ?></td>
                    <td><?php echo htmlspecialchars($session['heure_fin']); ?></td>
                    <td><?php echo htmlspecialchars($session['nbr_adherent']); ?></td>
                    <td><button class="join-session" data-id="<?php echo $session['id_seance']; ?>">Join</button></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
    $(".join-session").click(function() {
        var sessionId = $(this).data("id");
        $.post("../adherent/joinSeance.php", { session_id: sessionId }, function(response) {
            if (response.status === "success") {
                alert(response.message); 
                window.location.href = '../adherent/planning.php';
            } else {
                alert(response.message); 
            }
        }, "json");
    });

    function loadJoinedClasses() {
        $.get("../adherent/fetch_second_table.php", function(response) {
            $("#joined-classes-table").html(response);
        });
    }
});


    </script>
    <!-- <script>function goBack() {
        window.location.href = '../adherent/chooseCoach.php';
}</script> -->
</body>
</html>
