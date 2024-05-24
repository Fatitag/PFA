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
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $coach_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $coach = $result->fetch_assoc();
} else {
    header('Location: error.php');
    exit;
}

$sql = "SELECT id_seance, date_seance, heure_debut, heure_fin, nbr_adherent FROM seance WHERE id_coach = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $coach_id);
$stmt->execute();
$result = $stmt->get_result();

$sessions = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $sessions[] = $row;
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coach Details</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.7.0/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/dashboard.css">
    <link rel="stylesheet" href="../css/chooseCoach.css">
    <link rel="stylesheet" href="../css/coaches.css">

   
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
        <h3>Available Sessions</h3>
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
                loadJoinedClasses(); 
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
