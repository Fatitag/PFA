<?php
session_start();

require("../php/log_BD.php");

if (!isset($_SESSION['loggedin'])) {
    header('Location: ../index.php');
    exit;
}

$id_adherent = $_SESSION['id_adherent'];

$sql = "SELECT id_adherent, nom_adherent, prenom_adherent, phone, email_adherent, passwrd_adherent, images FROM adherent WHERE id_adherent = ?";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(1, $id_adherent, PDO::PARAM_STR);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);

if ($result) {
    $id = $result['id_adherent'];
    $fullName = $result['nom_adherent'] . " " . $result['prenom_adherent'];
    $phone = $result['phone'];
    $email = $result['email_adherent'];
    $password = $result['passwrd_adherent'];
    $profilePicture = $result['images']; 
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
        <!-- <link rel="stylesheet" href="../css/planning.css"> -->
        <link rel="stylesheet" href="../css/dashboard.css">
    <!-- <link rel="stylesheet" href="../css/profile.css"> -->

    <style>
        em {
            text-align: center;
            text-decoration: underline orange;
        }

        .profile-picture {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
        }

        .profile-info-container {
            display: flex;
            justify-content: center;
            margin-top: 20px; 
            text-align:center;

        }

        .card {
            width: 210px;
            height: 280px;
            background: rgb(239, 232, 232);
            border-radius: 12px;
            box-shadow: 0px 0px 30px rgba(0, 0, 0, 0.123);
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
            margin-right: 20px;
        }

        .profile-info {
            width: calc(100% - 250px);
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .label {
            width: 70px;
        }

        /* .info-container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 15px;
        } */

        .info-container {
        display: flex;
        align-items: center;
        justify-content: space-between;
        width: calc(100% - 10px);
        margin-bottom: 35px;
        margin-top:20px;
        text-align:center;

    }

        .edit-button {
            cursor: pointer;
            font-size: 1.2em;
            margin-left: 10px;
        }

        @media screen and (max-width: 768px) {
            .profile-info-container {
                flex-direction: column;
                align-items: center;
            }

            .card {
                margin-right: 0;
                margin-bottom: 20px;
            }

            .profile-info {
                width: 100%;
            }
        }
    </style>
</head>
<body>

<?php include_once("../adherent/sidebar.php"); ?>

<div class="content">
    <p class="profile"><h1><em>Profile</em></h1></p>
    
    <div class="profile-info-container">
        <div class="card">
            <?php if ($profilePicture !== null): ?>
                <img src="data:image/jpeg;base64,<?php echo base64_encode($profilePicture); ?>" alt="image" class="profile-picture">
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
                <div class="info-container">
                    <p class="label">Name:</p>
                    <p id="name" class="info"><?php echo $fullName; ?></p>
                    <a href="update_profile.php?field=nom_adherent"><button class="edit-button fas fa-pen"></button></a>
                </div><hr>
                <div class="info-container">
                    <p class="label">Phone:</p>
                    <p id="phone" class="info"><?php echo $phone; ?></p>
                    <a href="update_profile.php?field=phone"><button class="edit-button fas fa-pen"></button></a>
                </div>
                <hr>
                <div class="info-container">
                    <p class="label">Email:</p>
                    <p id="email" class="info"><?php echo $email; ?></p>
                    <a href="update_profile.php?field=email_adherent"><button class="edit-button fas fa-pen"></button></a>
                </div>
                <hr>
                <div class="info-container">
                    <p class="label">Password:</p>
                    <p id="password" class="info"><?php echo $password; ?></p>
                    <a href="update_profile.php?field=passwrd_adherent"><button class="edit-button fas fa-pen"></button></a>
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

