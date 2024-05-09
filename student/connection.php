<?php
// Informations de connexion à la base de données
$server_name = "localhost"; // Nom du serveur MySQL
$username = "root"; // Nom d'utilisateur MySQL
$password = ""; // Mot de passe MySQL
$database = "project"; // Nom de la base de données

// Connexion à la base de données MySQL
$conn = mysqli_connect($server_name, $username, $password, $database);

// Vérifie si la connexion a réussi
if (!$conn) {
    // Affiche un message d'erreur et arrête l'exécution du script en cas d'échec de connexion
    die("La connexion a échoué : " . mysqli_connect_error());
}
?>
