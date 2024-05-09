<?php
session_start();

// Check if the user is logged in as a teacher
if (!isset($_SESSION['teacher_id'])) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit();
}

// Include database connection
include_once "connection.php";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $class_name = $_POST['class_name'];
    $teacher_id = $_SESSION['teacher_id']; // Assuming teacher ID is set in session upon login
    $description = $_POST['description'];
    $keywords = $_POST['keywords'];
    $pre_requirements = $_POST['pre_requirements'];

    // Insert new class into database
    $insert_sql = "INSERT INTO classes (class_name, teacher_id, description, key_words, pre_requirements) VALUES ('$class_name', '$teacher_id', '$description', '$keywords', '$pre_requirements')";
    if (mysqli_query($conn, $insert_sql)) {
        echo "Cours ajouté avec succès!";
        header("Location: welcome.php");
    } else {
        echo "Erreur lors de l'ajout du cours : " . mysqli_error($conn);
    }
}

// Close database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php
    require_once "dashbord_head.html";
  ?>
<title>Ajouter un nouveau cours</title>
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
        <h2>Ajouter Un Nouveau Cours</h2>
        <form method="post" action="add_class.php">
            <label for="class_name">Intitulé Du Cours:</label>
            <input type="text" id="class_name" name="class_name" required><br><br>

            <label for="description">Description:</label><br>
            <textarea id="description" name="description" rows="4" cols="50" required></textarea><br><br>

            <label for="keywords">Mots Clés:</label>
            <input type="text" id="keywords" name="keywords"><br><br>

            <label for="pre_requirements">Les Prérequis:</label><br>
            <textarea id="pre_requirements" name="pre_requirements" rows="4" cols="50"></textarea><br><br>

            <input type="submit" value="Add Class">
        </form>
    </div>
</body>
<?php
  require_once "dashboard_script.html";
?>
</html>
