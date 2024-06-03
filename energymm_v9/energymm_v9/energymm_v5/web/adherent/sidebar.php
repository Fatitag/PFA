<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
    .sidebar
    {
        color: white !important;
    }
    </style>
</head>
<body>
<div class="sidebar">
    <img src="../images/energyme.png" alt="Logo" style="width: 200px; height: auto;">
    <div class="menu-items">
        <a href="../adherent/home.php">
            <div class="menu-item">
                <i class="bi bi-house"></i> Home
            </div>
        </a>
        <a href="../adherent/profile.php">
            <div class="menu-item">
                <i class="bi bi-person"></i> Profile
            </div>
        </a>
        <a href="../adherent/chooseCoach.php">
            <div class="menu-item">
                <i class="bi bi-person-badge"></i> Coaches
            </div>
        </a>
        <a href="../adherent/planning.php">
            <div class="menu-item">
                <i class="bi bi-calendar-event"></i> Planning
            </div>
        </a>
        <a href="../adherent/progAlim.php">
            <div class="menu-item">
                <i class="bi bi-journal"></i> Enroll program
            </div>
        </a>
        <a href="../adherent/ShowProg.php">
        <div class="menu-item">
            <i class="bi bi-calendar"></i> My meals plan
            </div>
        </a>
        <a href="../php/logout.php">
            <div class="menu-item">
                <i class="bi bi-box-arrow-right"></i> Logout
            </div>
        </a>
    </div>
</div>


<div class="navbar">
    <div class="logo"></div>
    <div class="search-notification">
        <div class="notification">
            <i class="bi bi-bell"></i>
        </div>
        <div> <?php echo $_SESSION['username']; ?></div>
    </div>
</div>

</body>
</html>