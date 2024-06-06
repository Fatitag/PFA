<?php
session_start();

if (!isset($_SESSION['loggedin'])) {
    header('Location: ../index.php');
    exit;
}

require("../php/log_BD.php");

$id_adherent = $_SESSION['id_adherent'];

$sql = "SELECT r.libele_repas, r.recette, r.quantite, r.instruction_repas
        FROM repas r
        JOIN plannutritionnel p ON r.id_plan_nutritionnel = p.id_plan_nutritionnel
        WHERE p.id_adherent = :id_adherent";


$stmt = $pdo->prepare($sql);
$stmt->bindParam(':id_adherent', $id_adherent, PDO::PARAM_INT);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

$meals = array('breakfast' => array(), 'lunch' => array(), 'snack' => array(), 'dinner' => array());

foreach ($result as $row) {
    $mealType = strtolower($row['libele_repas']);
    $meals[$mealType][] = $row;
}

$conn = null;
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.7.0/font/bootstrap-icons.css" rel="stylesheet">
    <title>Détails du plan nutritionnel</title>
    <link rel="stylesheet" href="../css/dashboard.css">
    <link rel="stylesheet" href="../css/ShowProg.css">
</head>
<body>
    <?php include_once("../adherent/sidebar.php"); ?>
    <script>
    var contentDiv = document.getElementById('repas');
            contentDiv.style.backgroundColor = '#ff7f00';
</script>

    <div class="content">
    <?php foreach (['breakfast', 'lunch', 'snack', 'dinner'] as $mealType): ?>
        <?php foreach ($meals[$mealType] as $meal): ?>
            <div class="recipe-section">
                <div class="recipe-image">
                    <img src="../images/<?php echo strtolower($meal['libele_repas']); ?>.jpeg" alt="<?php echo ucfirst($meal['libele_repas']); ?> Image">
                </div>
                <div class="recipe-details">
                    <h2><?php echo ucfirst($meal['libele_repas']); ?></h2>
                    <p><?php echo $meal['recette']; ?></p>
                    <p>Quantité: <?php echo $meal['quantite']; ?></p>
                    <a href="#" class="details-button" onclick="toggleDetails(event)">plus</a>
                    <div class="card" style="display: none;">
                        <h3>Instructions</h3>
                        <ul>
                            <?php
                            $instructions = explode("\n", $meal['instruction_repas']);
                            
                            foreach ($instructions as $instruction) {
                                echo '<li>' . $instruction . '</li>';
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endforeach; ?>

    <script>
        function toggleDetails(event) {
            event.preventDefault();
            var button = event.target;
            var card = button.nextElementSibling;
            if (card.style.display === "none") {
                card.style.display = "block";
                button.textContent = "moins";
            } else {
                card.style.display = "none";
                button.textContent = "plus";
            }
        }
    </script>

</div>
</body>
</html>
