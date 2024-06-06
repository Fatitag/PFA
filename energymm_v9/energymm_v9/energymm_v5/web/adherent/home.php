<?php
session_start();

require("../php/log_BD.php");

if (!isset($_SESSION['loggedin'])) {
    header('Location: ../index.php');
    exit;
}

if (!isset($pdo)) {
    header("Location: ../web/error.php");
    exit;
}

$id_adherent = $_SESSION['id_adherent'];

// Fetch the count of joined courses
$sql = "SELECT COUNT(*) as totalWorkoutsCompleted FROM inscriptionseance WHERE id_adherent = ?";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(1, $id_adherent, PDO::PARAM_INT);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$totalWorkoutsCompleted = $row['totalWorkoutsCompleted'];

// Fetch the registration date and name
$sql = "SELECT registration_date, nom_adherent, prenom_adherent FROM adherent WHERE id_adherent = ?";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(1, $id_adherent, PDO::PARAM_INT);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);

if ($result) {
    $first_name = $result['prenom_adherent'];
    $last_name = $result['nom_adherent'];
    $username = $first_name . " " . $last_name;
    $_SESSION['username'] = $username;
    $registrationDate = strtotime($result['registration_date']);
} else {
    $registrationDate = time();
}

$currentTimestamp = time();
$secondsSinceRegistration = $currentTimestamp - $registrationDate;
$daysSinceRegistration = floor($secondsSinceRegistration / (60 * 60 * 24));
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.7.0/font/bootstrap-icons.css" rel="stylesheet">

    <title>Bienvenue</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/dashboard.css">
    <link rel="stylesheet" href="../css/home.css">
    <style>.task-input-container {
    display: flex;
    align-items: center;
    margin-bottom: 1em;
}

#taskInput {
    flex: 1;
    padding: 0.5em;
    border: 1px solid #ccc;
    border-radius: 4px;
    margin-right: 0.5em;
}

#addTaskBtn {
    padding: 0.5em 1em;
    background-color: #ff7f00;
    border: none;
    color: white;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

#addTaskBtn:hover {
    background-color: #e66a00 !important;
}

#taskList {
    list-style-type: none;
    padding: 0;
}

.completed {
    text-decoration: line-through;
    color: grey;
}
</style>
</head>
<body>

<?php include_once("../adherent/sidebar.php"); ?>
<script>
    var contentDiv = document.getElementById('home');
    contentDiv.style.backgroundColor = '#ff7f00';
</script>

<div class="content">
    <h1>Bonjour, <?php echo htmlspecialchars($username); ?>!</h1>&nbsp;
    <p><em>Bienvenue sur votre tableau de bord personnalisé.</em> Ici, vous pouvez personnaliser la page selon vos préférences et accéder à différentes fonctionnalités.</p>
    <p>Explorez les <em>informations spécifiques à l'utilisateur</em>, les <em>prochains cours</em>, les <em>Ton plan d'alimentation si tu veux</em>, et plus encore.</p>

    <div class="card-container">
        <div class="statistic-card">
            <div class="card-header"><i class="bi bi-calendar-date"></i> Durée de l'adhésion</div><br>
            <div class="card-body">
                <p><?php echo $daysSinceRegistration; ?> jours</p>
            </div>
        </div>

        <div class="statistic-card">
            <div class="card-header"><i class="bi bi-stopwatch"></i> Total des Entraînements</div><br>
            <div class="card-body" id="workoutsCardBody">
                <span id="workoutsValue" style="cursor: pointer;"><?php echo htmlspecialchars($totalWorkoutsCompleted); ?></span>
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" id="workoutsForm" style="display: none;">
                    <input type="number" name="total_workouts" id="totalWorkoutsInput" value="<?php echo htmlspecialchars($totalWorkoutsCompleted); ?>">
                </form>
            </div>
        </div>

        <div class="statistic-card">
            <div class="card-header"><i class="bi bi-calendar-date"></i> Date d'aujourd'hui</div><br>
            <div class="card-body">
                <p><?php echo date('l, F j, Y'); ?></p>
            </div>
        </div>

        <div class="statistic-card">
            <div class="card-header"><i class="bi bi-list-check"></i> Ma Liste de Tâches</div><br>
            <div class="card-body">
                <div class="task-input-container">
                    <input type="text" id="taskInput" placeholder="Entrez une tâche">
                    <button id="addTaskBtn" onclick="addTask()">
                    <i class="bi bi-plus"></i>
                    </button>
                </div>
                <ul id="taskList"></ul>
            </div>
        </div>
        <div class="statistic-card">
            <div class="card-header"><i class="bi bi-heart"></i> Liste de souhaits</div>
            <div class="card-body">
                <p>Ajoutez vos cours et entraînements favoris à votre liste de souhaits.</p>
                <a href="../error.php" class="btn">Voir la liste de souhaits</a>
            </div>
        </div>

        <div class="statistic-card">
            <div class="card-header"><i class="bi bi-collection"></i> Mon Abonnement</div>
            <div class="card-body">
                <p>Gérez votre abonnement et les détails de votre adhésion.</p>
                <a href="#" class="btn">Gérer l'abonnement</a>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById("workoutsValue").addEventListener("click", function() {
        document.getElementById("workoutsValue").style.display = "none";
        document.getElementById("workoutsForm").style.display = "block";
        document.getElementById("totalWorkoutsInput").focus();
    });

    function addTask() {
        var taskInput = document.getElementById("taskInput");
        var task = taskInput.value.trim();
        if (task !== "") {
            var taskList = document.getElementById("taskList");
            var listItem = document.createElement("li");
            listItem.classList.add("task");
            listItem.innerHTML = `
                <input type="checkbox" onchange="toggleTaskCompletion(this)">
                <label>${task}</label>
                <i class="bi bi-trash delete-btn" onclick="removeTask(this)"></i>
            `;
            taskList.appendChild(listItem);
            taskInput.value = "";
            saveTasks();
        } else {
            alert("Please enter a valid task.");
        }
    }

    function toggleTaskCompletion(checkbox) {
        var label = checkbox.nextElementSibling;
        label.classList.toggle("completed");
        saveTasks();
    }

    function removeTask(deleteBtn) {
        var listItem = deleteBtn.parentElement;
        listItem.remove();
        saveTasks();
    }

    function saveTasks() {
        var taskList = document.getElementById("taskList").innerHTML;
        localStorage.setItem("tasks", taskList);
    }

    function loadTasks() {
        var savedTasks = localStorage.getItem("tasks");
        if (savedTasks) {
            document.getElementById("taskList").innerHTML = savedTasks;
        }
    }

    window.onload = loadTasks;
</script>

</body>
</html>
