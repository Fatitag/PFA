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
$result_nutritionnistes = $conn->query($sql_nutritionnistes);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $poids = $_POST['poids'];
    $taille = $_POST['taille'];
    $objectifs_sante = $_POST['objectifs_sante'];
    $allergies_alimentaires = $_POST['allergies_alimentaires'];
    $id_nutritionniste = $_POST['id_nutritionniste'];

    $sql = "INSERT INTO infosadherent (poids, taille, objectifs_sante, allergies_alimentaires, id_adherent, id_nutritionniste) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ddssii", $poids, $taille, $objectifs_sante, $allergies_alimentaires, $id_adherent, $id_nutritionniste);
    
    if ($stmt->execute()) {
        
    } else {
        echo "Erreur : " . $stmt->error;
    }
    
    $stmt->close();
    header("Location: ../adherent/progAlim.php"); 
    exit;
}

$conn->close();
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
    <link rel="stylesheet" href="../css/progAlim.css">


</head><body>

<?php include_once("../adherent/sidebar.php"); ?>

<div class="content">
    <div class="form-body">
        <div class="row">
            <div class="form-holder">
                <div class="form-content">
                    <div class="form-items">
                        <h3>Programme d'alimentation</h3>
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="requires-validation" novalidate>

                        <div class="col-md-12">
    <input class="form-control black-border" type="number"  name="poids" placeholder="Weight (kg)" required>
</div><br>

<div class="col-md-12">
    <input class="form-control black-border" type="number"  name="taille" placeholder="Height (cm)" required>
</div>
                            <div class="col-md-12">
                                <input class="form-control" type="text" name="objectifs_sante" placeholder="Health Goals" required>
                            </div>

                            <div class="col-md-12">
                                <input class="form-control" type="text" name="allergies_alimentaires" placeholder="Food Allergies" required>
                            </div>
                            <input type="hidden" name="id_adherent" value="<?php echo $id_adherent; ?>">

                            <div class="col-md-12" >
                                <?php if ($result_nutritionnistes->num_rows > 0) {
                                    echo '<select name="id_nutritionniste" class="form-control" required>';
                                    echo '<option value="">-- Select a nutritionnist --</option>';
                                    while($row = $result_nutritionnistes->fetch_assoc()) {
                                        echo '<option style="width: 600px;" value="' . $row['id_nutritionniste'] . '">' . $row['nom_nutritionniste'] . '</option>';
                                    }
                                    echo '</select>';
                                }  ?>                          
                            </div>
<br>
                            <div class="form-button mt-3">
    <button id="submit" type="submit" class="btn btn-primary">Send</button>
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
