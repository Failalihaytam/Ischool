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
$query = "SELECT * FROM teachers WHERE email = '$email'";
$result = mysqli_query($conn, $query);

if ($result && mysqli_num_rows($result) > 0) {
  $row = mysqli_fetch_assoc($result);
  $firstname = $row['firstName'];
  $lastname = $row['lastName'];
  $email = $row['email'];

  // Check if there's already a delete request for this student
  $query1 = "SELECT * FROM delete_requests WHERE user_id = {$row['id']} AND user_type = 'teacher'";
  $result1 = mysqli_query($conn, $query1);

  // Close database connection
  mysqli_close($conn);
} else {
  echo "Erreur lors de la récupération des informations utilisateur.";
  exit(); // Stop further execution if there's an error
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php
    require_once "dashbord_head.html";
  ?>
  <title>Profil</title>
  <style>
    .card {
      max-width: 900px;
      margin: 50px auto;
      padding: 20px;
      border: 1px solid #ccc;
      border-radius: 5px;
      box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    }
    </style>
</head>
<body>
  <div class="container">
  <?php
    require_once "dashbord_body.html";
    ?>
    <div class="main">
      <div class="topbar">
        <div class="toggle">
          <ion-icon name="menu-outline"></ion-icon>
        </div>
      </div>
      <div class="card">
    <h2>Informations Du Profil</h2>
    <p><strong>Prenom:</strong> <?php echo $firstname; ?></p>
    <p><strong>Nom:</strong> <?php echo $lastname; ?></p>
    <p><strong>Email:</strong> <?php echo $email; ?></p>
    <a href="edit_profile.php">Modifier le Profil</a>
    <?php
      if ($result1 && mysqli_num_rows($result1) > 0) {
        echo "<p>Demande déjà envoyée</p>";
      } else {
        echo "<a href='delete_profile.php'>Supprimer le profil</a>";
      }
    ?>
  </div>
</body>
<?php
  require_once "dashboard_script.html";
?>
</html>
