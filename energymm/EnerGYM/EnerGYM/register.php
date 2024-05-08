<?php
// Vérifier si le formulaire d'inscription est soumis
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Inclure le fichier de configuration de la base de données
    
    // Récupérer les données du formulaire
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hachage du mot de passe
    
    // Préparer la requête SQL
    $sql = "INSERT INTO adherant (email, passwrd_adherant) VALUES (?, ?)";
    
    if($stmt = $mysqli->prepare($sql)){
        // Lier les variables à la déclaration préparée en tant que paramètres
        $stmt->bind_param("ss", $param_email, $param_password);
        
        // Paramètres
        $param_email = $email;
        $param_password = $password;
        
        // Exécuter la déclaration
        if($stmt->execute()){
            // Rediriger l'utilisateur vers la page de connexion après l'inscription réussie
            header("location: login.php");
        } else{
            echo "Oops! Une erreur est survenue. Veuillez réessayer plus tard.";
        }

        // Fermer la déclaration
        $stmt->close();
    }
    
    // Fermer la connexion
    $mysqli->close();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Inscription - Mon Site</title>
  <!-- Liens vers Bootstrap CSS -->
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <!-- Liens vers les polices Google -->
  <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet">
  <!-- Liens vers les icônes Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body {
      font-family: 'Roboto', sans-serif;
      background-image: url('images/IMG-20240420-WA0024.jpg');
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
      background-attachment: fixed;
    }
    .register-container {
      max-width: 600px; /* Augmenter la largeur maximale */
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
      transition: border-color 0.3s ease-in-out;
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
      transition: background-color 0.3s ease-in-out;
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
      transition: color 0.3s ease-in-out;
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
      <input type="text" placeholder="Prénom" name="prenom" required>
      <input type="number" placeholder="Âge" name="age" required>
      <input type="email" placeholder="Adresse email" name="email" required>
      <input type="password" placeholder="Mot de passe" name="password" required>
      <button type="submit">S'inscrire <i class="bi bi-arrow-right"></i></button>
    </form>
    <div class="footer-text">
      <a href="login.php">Déjà inscrit? Connectez-vous ici</a>
    </div>
  </div>
</div>

</body>
</html>

