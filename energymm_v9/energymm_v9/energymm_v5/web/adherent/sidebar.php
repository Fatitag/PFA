<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>.menu-item {
    /* Ensure this class doesn't hide the item */
    display: flex;
    align-items: center;
    padding: 4px;
    color: white;
    text-decoration: none;
}

.menu-item:hover {
    background-color: #ff7f00;
}

.menu-item#planning {
    /* Make sure planning is visible */
    display: block;
    visibility: visible;
    opacity: 1;
}

</style>
</head>
<body>
<div class="sidebar">
    <img src="../images/energyme.png" alt="Logo" style="width: 200px; height: auto;">
    <div class="menu-items">
    <a href="../adherent/home.php" id="home" class="<?php echo basename($_SERVER['PHP_SELF']) == 'home.php' ? 'active' : ''; ?>">
    <div class="menu-item">
        <i class="bi bi-house"></i> Home
    </div>
</a>
        <a href="../adherent/profile.php" id="profile">
            <div class="menu-item" >
                <i class="bi bi-person"></i> Profile
            </div>
        </a>
        <a href="../adherent/chooseCoach.php" id="coach">
            <div class="menu-item">
                <i class="bi bi-person-badge"></i> Coaches
            </div>
        </a>
        <a href="../adherent/planning.php" id="planning">
            <div class="menu-item">
                <i class="bi bi-calendar-event"></i> Planning
            </div>
        </a>
        <a href="../adherent/progAlim.php" id="prog">
            <div class="menu-item">
                <i class="bi bi-journal"></i> Demande 
            </div>
        </a>
        <a href="../adherent/ShowProg.php" id="repas">
            <div class="menu-item">
                <i class="bi bi-calendar"></i>Plan repas
            </div>
        </a>
        <a href="../php/logout.php" id="logout">
            <div class="menu-item">
                <i class="bi bi-box-arrow-right"></i>Déconnecter
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
        <div><?php echo $_SESSION['username']; ?></div>
    </div>
</div>

</body>
</html>
