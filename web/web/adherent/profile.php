<?php
session_start();

require("../php/log_BD.php");

if (!isset($_SESSION['loggedin'])) {
    header('Location: ../index.php');
    exit;
}

$id_adherent = $_SESSION['id_adherent'];

$sql = "SELECT id_adherent, nom_adherent, prenom_adherent, phone, email_adherent, passwrd_adherent, images FROM adherent WHERE id_adherent = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $id_adherent);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $row = $result->fetch_assoc();
    $id = $row['id_adherent'];
    $fullName = $row['nom_adherent'] . " " . $row['prenom_adherent'];
    $phone = $row['phone'];
    $email = $row['email_adherent'];
    $password = $row['passwrd_adherent'];
    $profilePicture = $row['images']; 
    $profilePictureURL = isset($_SESSION['profilePictureURL']) ? $_SESSION['profilePictureURL'] : "placeholder.jpg";
} else {
    $id = "N/A";
    $fullName = "Full Name";
    $phone = "N/A";
    $email = "example@example.com";
    $password = "N/A";
    $profilePictureURL = "placeholder.jpg";
}

$_SESSION['profilePictureURL'] = $profilePictureURL;
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.7.0/font/bootstrap-icons.css" rel="stylesheet">
    <title>Bienvenue</title>
    <link rel="stylesheet" href="../css/planning.css">
    <link rel="stylesheet" href="../css/dashboard.css">
    <link rel="stylesheet" href="../css/profile.css">
    
</head>
<body>

<?php include_once("sidebar.php"); ?>

<div class="content">
    <p class="profile"><h1><em>Profile</em></h1></p>
    
    <div class="profile-info-container">
    <div class="card">
    <?php if ($profilePicture !== null): ?>
        <img src="data:images/jpeg;base64,<?php echo base64_encode($profilePicture); ?>" alt="image" class="profile-picture">
    <?php else: ?>
        <img src="<?php echo $profilePictureURL; ?>" alt="Profile Picture" class="profile-picture" onclick="document.getElementById('profile_picture').click();" id="display_picture">
    <?php endif; ?>
    <form action="profile.php" method="post" enctype="multipart/form-data">
        <input type="file" name="image" id="profile_picture" style="display: none;" onchange="displayImage(this)">
    </form>
    <h2><?php echo $fullName; ?></h2>
    <p>My ID: <?php echo $id; ?></p>
</div>

        <div class="profile-info">
            <div class="profile-section">
                <div>
                    <div class="info-container">
                        Name:<p id="name" class="info"><?php echo $fullName; ?></p>
                        <a href="../adherent/update_profile.php?field=nom_adherent"><button class="edit-button fas fa-pen"></button></a>
                    </div>
                </div>
                <hr>
                <div>
                    <div class="info-container">
                        Phone:<p id="phone" class="info"><?php echo $phone; ?></p>
                        <a href="../adherent/update_profile.php?field=phone"><button class="edit-button fas fa-pen"></button></a>
                    </div>
                </div>
                <hr>
                <div>
                    <div class="info-container">
                        Email:<p id="email" class="info"><?php echo $email; ?></p>
                        <a href="../adherent/update_profile.php?field=email_adherent"><button class="edit-button fas fa-pen"></button></a>
                    </div>
                </div>
                <hr>
                <div>
                    <div class="info-container">
                        Password:<p id="password" class="info"><?php echo $password; ?></p>
                        <a href="../adherent/update_profile.php?field=passwrd_adherent"><button class="edit-button fas fa-pen"></button></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function displayImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                document.getElementById('display_picture').src = e.target.result;
            }

            reader.readAsDataURL(input.files[0]);
        }
    }
</script>

</body>
</html>
