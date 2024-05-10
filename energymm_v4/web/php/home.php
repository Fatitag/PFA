<?php
session_start();

if (!isset($_SESSION['loggedin'])) {
    header('Location: ../index.php');
    exit;
}

$username = $_SESSION['email'];
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenue</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/dashboard.css">
    <link rel="stylesheet" href="../css/home.css">

</head>
<body>

<div class="sidebar">
    <img src="../images/energyme.png" alt="Logo" style="width: 100px; height: auto;">
    <a href="../php/home.php">Home</a>
    <a href="../php/profile.php">Profile</a>
    <a href="../php/planning.php">Planning</a>
    <a href="../php/progAlim.php">Programme d'alimentation</a>
    <a href="../php/logout.php">Logout</a>
</div>

<div class="navbar">
    <div class="logo"></div>
    <div class="search-notification">
        <input type="search" placeholder="Search...">
        <div class="notification">
            <i class="bi bi-bell"></i>
        </div>
        <div> <?php echo $username; ?></div>
    </div>
</div>

<div class="content">
    <h1>Welcome, <?php echo $username; ?>!</h1>
    <p>This is the dashboard page for adherents. You can customize this page with your desired content and features.</p>
    <p>For example, you can display user-specific information, upcoming classes, training plans, etc.</p>
    
    <div class="statistic-card">
        <h3>Total Days month</h3>
        <p><?php ?> daysVisited</p>

        <p><?php ?></p>
    </div>
    <div class="statistic-card">
        <h3>Average Visit </h3>
        <p><?php ?> minutes</p>
    </div>
    <div class="statistic-card">
        <h3>Total Workouts </h3>
        <p><?php?>minutes</p>
    </div>
</div>

</body>
</html>
