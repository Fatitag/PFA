<?php
session_start();

if (!isset($_SESSION['loggedin'])) {
    header('Location: ../index.html');
    exit;
}

$username = $_SESSION['email'];

// Check if the planning page is requested
$showPlanning = isset($_GET['page']) && $_GET['page'] === 'planning';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenue</title>
    <link rel="stylesheet" href="../css/planning.css">
    <link rel="stylesheet" href="../css/dashboard.css">

</head>
<body>

<div class="sidebar">
    <img src="../images/energyme.png" alt="Logo" style="width: 100px; height: auto;">
    <a href="../php/home.php">Home</a>
    <a href="#">Profile</a>
    <a href="../php/planning.php">planning</a>
    <a href="#">Programme d'alimentatio</a>
    <a href="../php/logout.php">Logout</a>
</div>

<div class="navbar">
    <div class="logo">Your Gym Name</div>
    <div class="search-notification">
        <input type="search" placeholder="Search...">
        <div class="notification">
            <i class="bi bi-bell"></i>
        </div>
        <div><?php echo $username; ?></div>
    </div>
</div>

<div class="content">
        <h1>Planning Table</h1>
        <table>
  <tr>
    <th>Company</th>
    <th>Contact</th>
    <th>Actions</th>
  </tr>
  <tr>
    <td>Alfreds Futterkiste</td>
    <td>Maria Anders</td>
    <td>Germany</td>
  </tr>
  <tr>
    <td>Centro comercial Moctezuma</td>
    <td>Francisco Chang</td>
    <td>Mexico</td>
  </tr>
  <tr>
    <td>Ernst Handel</td>
    <td>Roland Mendel</td>
    <td>Austria</td>
  </tr>
  <tr>
    <td>Island Trading</td>
    <td>Helen Bennett</td>
    <td>UK</td>
  </tr>
  <tr>
    <td>Laughing Bacchus Winecellars</td>
    <td>Yoshi Tannamuri</td>
    <td>Canada</td>
  </tr>
  <tr>
    <td>Magazzini Alimentari Riuniti</td>
    <td>Giovanni Rovelli</td>
    <td>Italy</td>
  </tr>
</table>
        
</div>
</div>

</body>
</html>
