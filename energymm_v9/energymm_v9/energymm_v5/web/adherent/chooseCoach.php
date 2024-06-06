<?php
session_start();

if (!isset($_SESSION['loggedin'])) {
    header('Location: ../index.php');
    exit;
}
require("../php/log_BD.php");

$sql = "SELECT id_coach, nom_coach, about_coach FROM coach";
$stmt = $pdo->prepare($sql);
$stmt->execute();

$coachs = [];
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $coachs[] = $row;
}
$pdo = null; 

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
    <!-- <link rel="stylesheet" href="../css/chooseCoach.css"> -->
<style>
.card {
    box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
    transition: 0.3s;
    width: 40%;
    height: 220px; 
    border-radius: 5px;
    
    flex: 0 0 auto;
    margin: 10px;
    overflow: hidden; 
    position: relative; 
    background-color: white; 
}
.card__icon {
    font-size: 20px;
    text-align: center;
    padding: 2px 16px;
    background-color: #ede0d4;
    border-top-left-radius: 5px;
    border-top-right-radius: 5px;
}

.card__exit {
    position: absolute;
    top: 50px;
    left: 30px;
    font-size: 18px;
}

.text {
    padding: 2px 16px;
    height: 200px; 
    overflow-y: auto; 
    display: flex;
    justify-content: center;
    align-items: center;
    text-align: center;
}

.card__apply {
    position: absolute;
    bottom: 10px;
    width: 100%;
    text-align: center;
    padding: 10px 16px;
}

.card__link {
    text-decoration: none;
    font-weight: bold;
    color: black; 
}

.card__link:hover {
    text-decoration: underline;
}

@media (max-width: 600px) {
    .card {
        width: 100%;
        height: auto; 
    }
}
.content {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
}
</style>

</head>
<body>

<?php include_once("../adherent/sidebar.php"); ?>
<script>
    var contentDiv = document.getElementById('coach');
            contentDiv.style.backgroundColor = '#ff7f00';
</script>

<div class="content">
    <?php foreach ($coachs as $coach): ?>
        <div class="card card-5">
            <div class="card__icon">🏋🏻 <?php echo htmlspecialchars($coach['nom_coach']); ?></div>
            <p class="card__exit">🎯</p>
            <div class="text"><?php echo nl2br(htmlspecialchars($coach['about_coach'])); ?></div>
            <p class="card__apply">
            <a class="card__link" href="../adherent/coachDetails.php?id=<?php echo $coach['id_coach']; ?>">join ici <i class="fas fa-arrow-right"></i></a>
            </p>
        </div>
    <?php endforeach; ?>
</div>

</body>
</html>
