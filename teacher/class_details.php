<?php
session_start();

// Check if the user is logged in as a teacher
if (!isset($_SESSION['teacher_id'])) {
    header("Location: my_classes.php"); // Redirect to login page if not logged in
    exit();
}

// Include database connection
include_once "connection.php";

// Check if the class ID is provided in the URL
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['class_id'])) {
    $class_id = $_GET['class_id'];

    // Fetch class details from database
    $class_query = "SELECT * FROM classes WHERE id = '$class_id' AND teacher_id = '" . $_SESSION['teacher_id'] . "'";
    $class_result = mysqli_query($conn, $class_query);

    if ($class_result && mysqli_num_rows($class_result) > 0) {
        $class_row = mysqli_fetch_assoc($class_result);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php
    require_once "dashbord_head.html";
    ?>
    <title>Détails du cours</title>
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
    <h2><?php echo $class_row['class_name']; ?></h2>
    <p><strong>Description:</strong> <?php echo $class_row['description']; ?></p>
    <p><strong>Mots Clés:</strong> <?php echo $class_row['key_words']; ?></p>
    <p><strong>Les Prérequis:</strong> <?php echo $class_row['pre_requirements']; ?></p>

    <a href='my_students.php?class_id=<?php echo $class_row['id']; ?>'>Mes étudiants</a><br>
    <a href='teacher_upload_form.php?class_id=<?php echo $class_row['id']; ?>'>Importer un nouveau chapitre</a><br>
    <a href='preview_chapters.php?class_id=<?php echo $class_row['id']; ?>'>Chapitres</a><br>
    <a href='update_class_info.php?class_id=<?php echo $class_row['id']; ?>'>Modifier les informations du cours</a><br>
    <a href='announcements.php?class_id=<?php echo $class_row['id']; ?>'>Annonces</a><br>
    <a href='messages.php?class_id=<?php echo $class_row['id']; ?>'>Messages</a><br>
</div>
</body>
<?php
  require_once "dashboard_script.html";
?>
</html>
<?php
    } else {
        echo "Cours introuvable ou vous n'êtes pas autorisé à afficher ce cours.";
    }
} else {
    echo "Requête invalide.";
}

// Close database connection
mysqli_close($conn);
?>
