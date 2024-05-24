<?php
session_start();

if (!isset($_SESSION['loggedin'])) {
    header('Location: ../index.php');
    exit;
}
require("../php/log_BD.php");

$sql = "SELECT id_coach, nom_coach, about_coach FROM coach";
$result = $conn->query($sql);

$coachs = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $coachs[] = $row;
    }
  }
  $conn->close();
//$id_adherent = $_SESSION['id_adherent'];

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.7.0/font/bootstrap-icons.css" rel="stylesheet">

    <title>Bienvenue</title>
    <link rel="stylesheet" href="../css/dashboard.css">
    <link rel="stylesheet" href="../css/chooseCoach.css">


</head>
<body>

<?php include_once("../adherent/sidebar.php"); ?>

<div class="content">
    <?php foreach ($coachs as $coach): ?>
        <div class="card card-5">
            <div class="card__icon">🏋🏻 <?php echo htmlspecialchars($coach['nom_coach']); ?></div>
            <p class="card__exit">🎯</p>
            <div class="text"><?php echo nl2br(htmlspecialchars($coach['about_coach'])); ?></div>
            <p class="card__apply">
            <a class="card__link" href="../adherent/coachDetails.php?id=<?php echo $coach['id_coach']; ?>">Apply Now <i class="fas fa-arrow-right"></i></a>
            </p>
        </div>
    <?php endforeach; ?>
</div>


</body>
</html>
