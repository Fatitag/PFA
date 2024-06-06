<?php
session_start();

if (!isset($_SESSION['loggedin'])) {
    header('Location: ../index.php');
    exit;
}
require("../php/log_BD.php");
$id_adherent = $_SESSION['id_adherent'];
if (isset($_SESSION['id_adherent'])) {
    $id_adherent = $_SESSION['id_adherent'];
} else {
}  
$sql_nutritionnistes = "SELECT id_nutritionniste, nom_nutritionniste FROM nutritionniste";
$stmt_nutritionnistes = $pdo->prepare($sql_nutritionnistes);
$stmt_nutritionnistes->execute();
$result_nutritionnistes = $stmt_nutritionnistes->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $poids = $_POST['poids'];
    $taille = $_POST['taille'];
    $objectifs_sante = $_POST['objectifs_sante'];
    $allergies_alimentaires = $_POST['allergies_alimentaires'];
    $id_nutritionniste = $_POST['id_nutritionniste'];

    $sql = "INSERT INTO infosadherent (poids, taille, objectifs_sante, allergies_alimentaires, id_adherent, id_nutritionniste) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(1, $poids);
    $stmt->bindParam(2, $taille);
    $stmt->bindParam(3, $objectifs_sante);
    $stmt->bindParam(4, $allergies_alimentaires);
    $stmt->bindParam(5, $id_adherent);
    $stmt->bindParam(6, $id_nutritionniste);
    
    if ($stmt->execute()) {
        
    } else {
        echo "Erreur : " . $stmt->errorInfo()[2];
    }
    
    $stmt = null;
    header("Location: ../adherent/progAlim.php"); 
    exit;
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

    <title>Welcome</title>
    <!-- <link rel="stylesheet" href="../css/planning.css"> -->
    <link rel="stylesheet" href="../css/dashboard.css">
    <!-- <link rel="stylesheet" href="../css/progAlim.css"> -->
<style>@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;700;900&display=swap');

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

html, body {
    background-color: #ffffff;
    overflow-x: hidden;
    font-family: 'Poppins', sans-serif;
}

.form-holder {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    text-align: center;
    padding: 20px;
}

.form-content {
    position: relative;
    text-align: center;
    display: flex;
    justify-content: center;
    align-items: center;
    width: 50%;
    max-width: 800px;
    margin: 0 auto;
}

.form-content .form-items {
    border: 3px solid #000000;
    padding: 20px;
    display: inline-block;
    width: 100%;
    border-radius: 20px;
    text-align: left;
    transition: all 0.4s ease;
}

.form-content h3 {
    color: #d17732;
    text-align: center;
    font-size: 28px;
    margin-bottom: 5px;
    margin-top: 1px;
    text-decoration: none;
}

.form-content input[type=text], 
.form-content input[type=password], 
.form-content input[type=email], 
.form-content input[type=number], 
.form-content select {
    width: calc(100% - 40px); 
    padding: 9px 20px;
    text-align: left;
    border: 2px solid black; 
    outline: 0;
    border-radius: 6px;
    background-color: #ffffff;
    font-size: 15px;
    font-weight: 300;
    color: #000000;
    transition: all 0.3s ease;
    margin-top: 16px;
}

.btn-primary {
    background-color: #6C757D;
    outline: none;
    border: 2px solid #000000;
    box-shadow: none;
    padding: 10px 20px;
    font-size: 18px;
    cursor: pointer;
    border-radius: 10px;
}

.btn-primary:hover, .btn-primary:focus, .btn-primary:active {
    background-color: #5a646c;
    outline: none !important;
    border: 2px solid #000000;
    box-shadow: none;
}

.form-button {
    display: flex;
    justify-content: center;
    margin-top: 20px;
}

@media (max-width: 768px) {
    .form-content .form-items {
        width: 90%; 
    }

    .form-content input[type=text], 
    .form-content input[type=password], 
    .form-content input[type=email], 
    .form-content input[type=number], 
    .form-content select {
        width: calc(100% - 20px); 
        padding: 8px 10px;
        font-size: 14px;
    }

    .btn-primary {
        padding: 8px 16px;
        font-size: 16px;
    }
}
h2{
    text-align:center;
}
h4{
    color:#d17732;
    text-align:center;
}
</style>

</head>
<body>

<?php include("../adherent/sidebar.php"); ?>
<script>
    var contentDiv = document.getElementById('prog');
            contentDiv.style.backgroundColor = '#ff7f00';
</script>

<div class="content">
    <div class="form-body">
    <h2>Demande pour suivre un programme nutritionelle</h2>

        <div class="row">
            <div class="form-holder">
                <div class="form-content">
                    <div class="form-items">
                        <h4>Ayons une vie saine!</h4>
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="requires-validation" novalidate>

                        <div class="col-md-12">
                            <input class="form-control black-border" type="number"  name="poids" placeholder="poids (kg)" required>
                        </div><br>

                        <div class="col-md-12">
                            <input class="form-control black-border" type="number"  name="taille" placeholder="taille (cm)" required>
                        </div>
                        <div class="col-md-12">
                            <input class="form-control" type="text" name="objectifs_sante" placeholder="objectif" required>
                        </div>

                        <div class="col-md-12">
                            <input class="form-control" type="text" name="allergies_alimentaires" placeholder="allergie alimentaire" required>
                        </div>
                        <input type="hidden" name="id_adherent" value="<?php echo $id_adherent; ?>">

                        <div class="col-md-12">
                            <?php if (count($result_nutritionnistes) > 0) {
                                echo '<select name="id_nutritionniste" class="form-control" required>';
                                echo '<option value="">-- Selectionner une nutritionniste --</option>';
                                foreach($result_nutritionnistes as $row) {
                                    echo '<option style="width: 600px;" value="' . $row['id_nutritionniste'] . '">' . $row['nom_nutritionniste'] . '</option>';
                                }
                                echo '</select>';
                            }  ?>                          
                        </div><br>
                        <div class="form-button mt-3">
                            <button id="submit" type="submit" class="btn btn-primary">Envoyer</button>
                        </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
