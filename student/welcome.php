<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION["email"])) {
  // Redirect to the login page if not logged in
  header("Location: index.html");
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Bienvenue</title>
</head>
<body>
  <div class="container">
    <h2>Bienvenue sur le site web</h2>
    <p>Vous êtes maintenant connecté. Profitez de votre séjour !</p>
    <a href="logout.php">Déconnexion</a>
    <a href="classes.php">S'inscrire à Un Cour</a>
    <a href="my_classes.php">Mes cours</a>
    <a href="profile.php">Profil</a>
  </div>
</body>
</html>
