<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Connexion - my page</title>
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <link href="css/style.css">
  <style>
    * {
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
    try {
        $pdo = new PDO($dsn, $username, $password); // Utilisation de $dsn
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        if (isset($_POST['email'], $_POST['password']) && !empty($_POST['email']) && !empty($_POST['password'])) {
            $email = $_POST['email'];
            $password = $_POST['password'];
            
            $stmt = $pdo->prepare("SELECT id_adherent FROM adherent WHERE email_adherent=? AND passwrd_adherent=?");
            $stmt->bindParam(1, $email);
            $stmt->bindParam(2, $password);
            $stmt->execute();
            
            if ($stmt->rowCount() == 1) {
                $row = $stmt->fetch(PDO::FETCH_ASSOC); 
                $_SESSION['loggedin'] = true;
                $_SESSION['id_adherent'] = $row['id_adherent']; 
                header("Location: ../adherent/home.php");
                exit();
            } else {
                $error = "Adresse email ou mot de passe incorrect";
            }
        } else {
            $error = "Veuillez remplir tous les champs.";
        }
    } catch (PDOException $e) {
        die("Connection failed: " . $e->getMessage());
    }
}
?>

<body>

<div class="container">
  <div class="login-container">
    <h2>Connexion</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <input type="text" placeholder="Email" name="email" required>
    <input type="password" placeholder="Password" name="password" required>
    <button type="submit">Log in <i class="bi bi-arrow-right"></i></button>
    </form>
    <div class="footer-text">
      <a href="../php/register.php">Register</a><br>
      <a href="../php/reset_password.php">Forget password ?</a> &nbsp;
      <a href="../index.php">Back to home</a>
    </div>
    <?php if(isset($error)) { ?>
      <div class="alert alert-danger mt-3" role="alert"><?php echo $error; ?></div>
    <?php } ?>
  </div>
</div>
</body>
</html>
