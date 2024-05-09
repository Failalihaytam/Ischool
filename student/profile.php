<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION["email"])) {
  // Redirect to the login page if not logged in
  header("Location: index.html");
  exit();
}

// Include database connection
include_once "connection.php";

// Get student's information from the database
$email = $_SESSION["email"];
$query = "SELECT * FROM students WHERE email = '$email'";
$result = mysqli_query($conn, $query);

if ($result && mysqli_num_rows($result) > 0) {
  $row = mysqli_fetch_assoc($result);
  $firstname = $row['firstname'];
  $lastname = $row['lastname'];
  $email = $row['email'];

  // Check if there's already a delete request for this student
  $query1 = "SELECT * FROM delete_requests WHERE user_id = {$row['id']} AND user_type = 'student'";
  $result1 = mysqli_query($conn, $query1);

  // Close database connection
  mysqli_close($conn);
} else {
  echo "Erreur lors de la récupération des informations de l'utilisateur.";
  exit(); // Stop further execution if there's an error
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Profil</title>
</head>
<body>
  <div class="container">
    <h2>Informations de Profil</h2>
    <p><strong>Prénom :</strong> <?php echo $firstname; ?></p>
    <p><strong>Nom :</strong> <?php echo $lastname; ?></p>
    <p><strong>Email :</strong> <?php echo $email; ?></p>
    <a href="edit_profile.php">Modifier le Profil</a>
    <?php
      if ($result1 && mysqli_num_rows($result1) > 0) {
        echo "<p>Demande déjà envoyée</p>";
      } else {
        echo "<a href='delete_profile.php'>Supprimer le Profil</a>";
      }
    ?>
  </div>
</body>
</html>
