<?php
session_start();

require("../php/log_BD.php");

if (!isset($_SESSION['loggedin'])) {
    header('Location: ../index.php');
    exit;
}
$id_adherent = $_SESSION['id_adherent'];
$sql = "SELECT registration_date FROM adherent WHERE id_adherent = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $id_adherent);
$stmt->execute();
$result = $stmt->get_result();

$stmt_name = $conn->prepare("SELECT nom_adherent, prenom_adherent FROM adherent WHERE id_adherent=?");
$stmt_name->bind_param("i",$id_adherent);
$stmt_name->execute();
$result_name = $stmt_name->get_result();

if ($result_name->num_rows == 1) {
    $row = $result_name->fetch_assoc(); // Récupère la ligne de résultat sous forme de tableau associatif

    $first_name = $row['prenom_adherent'];
    $last_name = $row['nom_adherent'];

    $username = $first_name . " " . $last_name;
    $_SESSION['username'] = $username ;
}


if ($result->num_rows === 1) {
    $row = $result->fetch_assoc();
    $registrationDate = strtotime($row['registration_date']);
} else {
    $registrationDate = time(); 
}

$currentTimestamp = time();
$secondsSinceRegistration = $currentTimestamp - $registrationDate;
$daysSinceRegistration = floor($secondsSinceRegistration / (60 * 60 * 24));

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $totalWorkoutsCompleted = $_POST['total_workouts'];
} else {
    $totalWorkoutsCompleted = 0;
}

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
</head>
<body>

<?php include_once("../adherent/sidebar.php"); ?>

<div class="content">
    <h1>Welcome, <?php echo $username; ?>!</h1>
    <p><em>Welcome to your personalized dashboard.</em> Here, you can tailor the page to suit your preferences and access various features.</p>
    <p>Explore <em>user-specific information</em>, <em>upcoming classes</em>, <em>training plans</em>, and more.</p>

    <div class="card-container">
        <div class="statistic-card">
            <div class="card-header"><i class="bi bi-calendar-date"></i> Membership Duration</div><br>
            <div class="card-body">
                <p><?php echo $daysSinceRegistration; ?> days</p>
            </div>
        </div>

        <div class="statistic-card">
    <div class="card-header"><i class="bi bi-stopwatch"></i> Total Workouts</div><br>
    <div class="card-body" id="workoutsCardBody">
        <span id="workoutsValue" style="cursor: pointer;"><?php echo $totalWorkoutsCompleted; ?></span>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" id="workoutsForm" style="display: none;">
            <input type="number" name="total_workouts" id="totalWorkoutsInput" value="<?php echo $totalWorkoutsCompleted; ?>">
        </form>
    </div>
</div>


<div class="statistic-card">
    <div class="card-header"><i class="bi bi-calendar-date"></i> Today's Date</div><br>
    <div class="card-body">
        <p><?php echo date('l, F j, Y'); ?></p>
    </div>
</div>


<div class="statistic-card">
    <div class="card-header"><i class="bi bi-list-check"></i> My To-Do List</div><br>
    <div class="card-body">
        <input type="text" id="taskInput" placeholder="Enter a task">
        <button id="addTaskBtn" onclick="addTask()">Add Task</button>
    </div>
    <ul id="taskList"></ul>
</div>

        <div class="statistic-card">
            <div class="card-header"><i class="bi bi-heart"></i> Wishlist</div>
            <div class="card-body">
                <p>Add your favorite classes and workouts to your wishlist.</p>
                <a href="#" class="btn">View Wishlist</a>
            </div>
        </div>

        <div class="statistic-card">
            <div class="card-header"><i class="bi bi-collection"></i> My Subscription</div>
            <div class="card-body">
                <p>Manage your subscription and membership details .</p>
                <a href="#" class="btn">Manage Subscription</a>
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
</script>
<script>
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

