<?php
$server_name = "localhost"; // Nom du serveur MySQL
$username = "root"; // Nom d'utilisateur MySQL
$password =""; // Mot de passe MySQL
$database = "project"; // Nom de la base de données

$conn = mysqli_connect($server_name, $username, $password, $database); // Connexion à la base de données MySQL

if (!$conn) {
    // Vérification de la connexion réussie à la base de données
    // Si la connexion échoue, affiche un message d'erreur avec les détails de l'erreur
    die("La connexion a échoué: " . mysqli_connect_error());
}
?>
