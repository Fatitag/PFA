<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Réinitialisation de mot de passe</title>
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body {
      font-family: 'Roboto', sans-serif;
      background-image: url('../images/IMG-20240420-WA0024.jpg');
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
      background-attachment: fixed;
    }
    .reset-container {
      max-width: 600px;
      margin: 100px auto;
      padding: 30px;
      background-color: rgba(0, 0, 0, 0.7);
      border-radius: 10px;
      box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.1);
    }
    .reset-container h2 {
      text-align: center;
      margin-bottom: 30px;
      color: #ff7f00;
    }
    .reset-container form input[type="email"] {
      width: 100%;
      padding: 12px;
      margin-bottom: 20px;
      border: none;
      border-bottom: 1px solid #ff7f00;
      background-color: transparent;
      color: #ffffff;
      transition: border-color 0.3s ease-in-out;
    }
    .reset-container form input[type="email"]:focus {
      border-bottom-color: #ffffff;
      outline: none;
    }
    .reset-container form button {
      width: 100%;
      padding: 12px;
      border: none;
      border-radius: 5px;
      background-color: #ff7f00;
      color: #000000;
      cursor: pointer;
      transition: background-color 0.3s ease-in-out;
    }
    .reset-container form button:hover {
      background-color: #ffa94d;
    }
    .reset-container .footer-text {
      text-align: center;
      margin-top: 20px;
      color: #ffffff;
    }
    .reset-container .footer-text a {
      color: #ff7f00;
      text-decoration: none;
      transition: color 0.3s ease-in-out;
    }
    .reset-container .footer-text a:hover {
      color: #ffa94d;
    }
  </style>
</head>
<body>

<div class="container">
  <div class="reset-container">
    <h2>Réinitialisation de mot de passe</h2>
    <form method="post" action="../reset_password.php">
      <input type="email" placeholder="Adresse email associée au compte" name="email" required>
      <button type="submit">Réinitialiser le mot de passe <i class="bi bi-arrow-right"></i></button>
    </form>
    <div class="footer-text">
      <a href="../index.php">Retour à la page d'acceuil</a>
    </div>
  </div>
</div>

</body>
</html>
