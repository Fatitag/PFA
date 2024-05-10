<?php
/*$serveur = "localhost"; 
$utilisateur = "rooot"; 
$mot_de_passe = "salle_sport";
$bdd = "rooot"; 
$conn = mysqli_connect($serveur, $utilisateur, $mot_de_passe, $bdd);
*/?>
<?php
$servername = "localhost";
 $database = "gymdb";
 $username = "root";
 $password = "";
 $port = 3307;
 $conn = new mysqli($servername, $username, $password, $database, $port);
?>