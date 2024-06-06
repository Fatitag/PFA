<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);

require("../php/log_BD.php");

$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST['nom'])) {
        $errors[] = "First Name is required.";
    } else {
        $nom = $_POST['nom'];
        if (!preg_match("/^[a-zA-Z-' ]*$/", $nom)) {
            $errors[] = "Only letters and white space allowed in First Name.";
        }
    }

    if (empty($_POST['prenom'])) {
        $errors[] = "Last Name is required.";
    } else {
        $prenom = $_POST['prenom'];
        if (!preg_match("/^[a-zA-Z-' ]*$/", $prenom)) {
            $errors[] = "Only letters and white space allowed in Last Name.";
        }
    }

    // Validate age
    if (empty($_POST['age'])) {
        $errors[] = "Age is required.";
    } else {
        $age = $_POST['age'];
        if (!is_numeric($age) || $age < 15) {
            $errors[] = "Age must be a number and at least 15 years old.";
        }
    }

    if (empty($_POST['email'])) {
        $errors[] = "Email is required.";
    } else {
        $email = $_POST['email'];
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Invalid email format.";
        }
    }

    if (empty($_POST['password'])) {
        $errors[] = "Password is required.";
    } else {
        $password = $_POST['password'];
        if (strlen($password) < 8) {
            $errors[] = "Password must be at least 8 characters long.";
        }
    }

    if (empty($errors)) {
      $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO visiteur (nom_visiteur, prenom_visiteur, age_visiteur, email_visiteur, passwrd_visiteur) VALUES (?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$nom, $prenom, $age, $email, $password]);

        if ($stmt->rowCount() === 1) {
            $_SESSION['registered'] = true;
            header("Location: ../adherent/home.php");
            exit();
        } else {
            $errors[] = "An error occurred during registration. Please try again.";
        }

        $stmt = null;
        $pdo = null;
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Inscription - Mon Site</title>
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body, html {
      font-family: 'Roboto', sans-serif;
      transition: all 0.3s ease-in-out;
    }
    body {
      background-image: url('../images/IMG-20240420-WA0024.jpg');
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
      background-attachment: fixed;
    }
    .register-container {
      max-width: 600px; 
      margin: 100px auto;
      padding: 30px;
      background-color: rgba(0, 0, 0, 0.7);
      border-radius: 10px;
      box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.1);
    }
    .register-container h2 {
      text-align: center;
      margin-bottom: 30px;
      color: #ff7f00;
    }
    .register-container form input[type="text"],
    .register-container form input[type="password"],
    .register-container form input[type="email"],
    .register-container form input[type="number"] {
      width: 100%;
      padding: 12px;
      margin-bottom: 20px;
      border: none;
      border-bottom: 1px solid #ff7f00;
      background-color: transparent;
      color: #ffffff;
    }
    .register-container form input[type="text"]:focus,
    .register-container form input[type="password"]:focus,
    .register-container form input[type="email"]:focus,
    .register-container form input[type="number"]:focus {
      border-bottom-color: #ffffff;
      outline: none;
    }
    .register-container form button {
      width: 100%;
      padding: 12px;
      border: none;
      border-radius: 5px;
      background-color: #ff7f00;
      color: #000000;
      cursor: pointer;
    }
    .register-container form button:hover {
      background-color: #ffa94d;
    }
    .register-container .footer-text {
      text-align: center;
      margin-top: 20px;
      color: #ffffff;
    }
    .register-container .footer-text a {
      color: #ff7f00;
      text-decoration: none;
    }
    .register-container .footer-text a:hover {
      color: #ffa94d;
    }
  </style>
</head>
<body>

<div class="container">
  <div class="register-container">
    <h2>Inscription</h2>
    <form method="post" action="register.php">
      <input type="text" placeholder="Nom" name="nom" required>
      <input type="text" placeholder="Prenom" name="prenom" required>
      <input type="number" placeholder="Age" name="age" required>
      <input type="email" placeholder="Email" name="email" required>
      <input type="password" placeholder="Mot de passe" name="password" required>
      <button type="submit">S'inscrire <i class="bi bi-arrow-right"></i></button>
    </form>
    <div class="footer-text">
    <a href="../php/login.php">Déjà inscrit ? Connectez-vous ici</a>
    </div>
    <?php
    if (!empty($errors)) {
        echo '<div class="alert alert-danger mt-3">';
        foreach ($errors as $error) {
            echo '<p>' . htmlspecialchars($error) . '</p>';
        }
        echo '</div>';
    }
    ?>
  </div>
</div>

</body>
</html>
