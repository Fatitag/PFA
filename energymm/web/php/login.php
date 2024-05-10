

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Connexion - Mon Site</title>
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <link href="css/style.css">
  <style>
    body {
      font-family: 'Roboto', sans-serif;
      background-image: url('../images/IMG-20240420-WA0024.jpg');
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
      background-attachment: fixed;
    }
    .login-container {
      max-width: 400px;
      margin: 100px auto;
      padding: 30px;
      background-color: rgba(0, 0, 0, 0.7);
      border-radius: 10px;
      box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.1);
    }
    .login-container h2 {
      text-align: center;
      margin-bottom: 30px;
      color: #ff7f00;
    }
    .login-container form input[type="text"],
    .login-container form input[type="password"] {
      width: 100%;
      padding: 12px;
      margin-bottom: 20px;
      border: none;
      border-bottom: 1px solid #ff7f00;
      background-color: transparent;
      color: #ffffff;
      transition: border-color 0.3s ease-in-out;
    }
    .login-container form input[type="text"]:focus,
    .login-container form input[type="password"]:focus {
      border-bottom-color: #ffffff;
      outline: none;
    }
    .login-container form button {
      width: 100%;
      padding: 12px;
      border: none;
      border-radius: 5px;
      background-color: #ff7f00;
      color: #000000;
      cursor: pointer;
      transition: background-color 0.3s ease-in-out;
    }
    .login-container form button:hover {
      background-color: #ffa94d;
    }
    .login-container .footer-text {
      text-align: center;
      margin-top: 20px;
      color: #ffffff;
    }
    .login-container .footer-text a {
      color: #ff7f00;
      text-decoration: none;
      transition: color 0.3s ease-in-out;
    }
    .login-container .footer-text a:hover {
      color: #ffa94d;
    }
  </style>
</head>
<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);

if ($_SERVER["REQUEST_METHOD"] == "POST") { 
    require("../php/log_BD.php");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $email = $_POST['email'];
    $password = $_POST['password'];
    $stmt = $conn->prepare("SELECT * FROM adherant WHERE email=? AND passwrd_adherant=?");
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {        $_SESSION['loggedin'] = true;
        $_SESSION['email'] = $email;
        header("Location: ../php/home.php");
        exit();
    } else {        $error = "Adresse email ou mot de passe incorrect";
    }

    $stmt->close();
    $conn->close();
}
?>

<body>

<div class="container">
  <div class="login-container">
    <h2>Connexion</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <input type="text" placeholder="Adresse email" name="email" required>
    <input type="password" placeholder="Mot de passe" name="password" required>
    <button type="submit">Se connecter <i class="bi bi-arrow-right"></i></button>
</form>

    </form>
    <div class="footer-text">
    <a href="../php/register.php">Register</a><br>
      <a href="../php/reset_password.php">Mot de passe oublié ?</a>
      <a href="../index.html">Retour</a>

    </div>
    <?php if(isset($error)) { ?>
      <div class="alert alert-danger mt-3" role="alert"><?php echo $error; ?></div>
    <?php } ?>
  </div>
</div>
</body>
</html>
