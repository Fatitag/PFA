<?php
session_start();

require("../php/log_BD.php");

if (!isset($_SESSION['loggedin'])) {
    header('Location: ../index.php');
    exit;
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $field = $_GET['field'];
    $newValue = $_POST[$field];

    $id_adherent = $_SESSION['id_adherent'];
    $sql = "UPDATE adherent SET $field = :newValue WHERE id_adherent = :id_adherent";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':newValue', $newValue);
    $stmt->bindParam(':id_adherent', $id_adherent);
    $stmt->execute();

    header('Location: profile.php');
    exit;
}

$id_adherent = $_SESSION['id_adherent'];
$sql = "SELECT * FROM adherent WHERE id_adherent = :id_adherent";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':id_adherent', $id_adherent);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);

if ($result) {
    $field = $_GET['field'];
    $currentValue = $result[$field];
    $fieldName = ucfirst(str_replace('_', ' ', $field));

} else {
    header("Location: ../web/error.html");
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Profile</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.7.0/font/bootstrap-icons.css" rel="stylesheet">
    <!-- <link rel="stylesheet" href="../css/planning.css"> -->
    <link rel="stylesheet" href="../css/dashboard.css">
    <!-- <link rel="stylesheet" href="../css/profile.css"> -->
    <style>
        /* .form-container {
            max-width: 700px;
            margin: 80px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 7px;
            box-shadow: 5px 5px 5px 5px rgba(0, 0, 0, 0.1);
            border: 1px solid #ccc; 
            justify-content:center;
        } */
        
        content {
    display: flex;
    align-items: center;
    max-width: 700px;
            margin: 80px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 7px;
            box-shadow: 5px 5px 5px 5px rgba(0, 0, 0, 0.1);
            border: 1px solid #ccc; 
            justify-content:center;
}

.form-container {
    max-width: 700px;
    padding: 20px;
    background-color: #fff;
    border-radius: 7px;
    box-shadow: 5px 5px 5px 5px rgba(0, 0, 0, 0.1);
    border: 1px solid #ccc;
    text-align: center; 
}

@media (max-width: 767px) {
    .form-container {
        width: 90%;
    }
}

@media (max-width: 480px) {
    .form-container {
        width: 90%;
    }
    h2 {
        font-size: 20px;
    }
}

        .form-group {
            margin-bottom: 20px;
        }

        h2 {
            font-size: 24px;
            margin-bottom: 20px;
            text-align: center;
        }

        label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 90%;
            padding: 15px;
            margin-top: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        button {
            background-color: orange;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color: orange;
        }
@media (min-width: 768px) {
    .form-container {
        width: 50%;
        margin: 80px auto;
    }
}

@media (max-width: 767px) {
    .form-container {
        width: 70%;
    }
    input[type="text"],
    input[type="email"],
    input[type="password"],
    button {
        width: 100%;
        margin-top: 0;
        margin-bottom: 15px;
    }
}

@media (max-width: 480px) {
    .form-container {
        width: 90%;
        margin: 20px auto;
    }
    h2 {
        font-size: 20px;
    }
}

    </style>
</head>
<body>
<?php include_once("../adherent/sidebar.php"); ?>

<div class="content">
<div class="form-container">

    <h2>Update Profile</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?field=' . $_GET['field']; ?>" method="post">
        <div class="form-group">
            <label for="<?php echo $_GET['field']; ?>"><?php echo $fieldName; ?>:</label>
            <input type="text" id="<?php echo $_GET['field']; ?>" name="<?php echo $_GET['field']; ?>" value="<?php echo $currentValue; ?>" required>
        </div>
        <div class="form-group">
            <button type="submit">Update</button>
        </div>
    </form>
</div>
</div>
</body>
</html>
