<?php
// Start session
session_start();

// Check if user is not logged in, redirect to login page
if (!isset($_SESSION['loggedin'])) {
    header('Location: index.html');
    exit;
}

// Retrieve username from session
$username = $_SESSION['email'];
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenue</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #ffffff;
        }
        .navbar {
            background-color: #000000;
            color: #ffffff;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
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
            background-color:#000000 ;
            color: #ffffff;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            padding: 20px;
        }
        .sidebar a {
            color: #ffffff;
            text-decoration: none;
            display: block;
            margin-bottom: 10px;
        }
        .content {
            margin-left: 250px;
            padding: 20px;
        }
    </style>
</head>
<body>

<div class="sidebar">
    <!-- Place your logo here -->
    <img src="images/energyme.png" alt="Logo" style="width: 100px; height: auto;">
    <a href="#">Dashboard</a>
    <a href="#">Profile</a>
    <a href="#">Settings</a>
    <a href="logout.php">Logout</a>
</div>

<div class="navbar">
    <div class="logo">Your Gym Name</div>
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
</div>

</body>
</html>
