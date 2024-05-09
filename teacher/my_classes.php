<?php
session_start();

// Include database connection
include_once "connection.php";

// Check if the user is logged in as a teacher
if (!isset($_SESSION['teacher_id'])) {
    header("Location: welcome.php"); // Redirect to login page if not logged in
    exit();
}

// Get teacher ID from session
$teacher_id = $_SESSION['teacher_id'];

// Fetch classes created by the teacher from database
$classes_query = "SELECT * FROM classes WHERE teacher_id = '$teacher_id'";
$classes_result = mysqli_query($conn, $classes_query);

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php
    require_once "dashbord_head.html";
    ?>
    <title>Vos cours</title>
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
        <h2>Vos cours</h2>

        <?php
        if (mysqli_num_rows($classes_result) > 0) {
            while ($class_row = mysqli_fetch_assoc($classes_result)) {
                echo "<a href='class_details.php?class_id=" . $class_row['id'] . "'>" . $class_row['class_name'] . "</a><br>";
            }
        } else {
            echo "Vous n'avez pas encore créé de cours.";
        }
        mysqli_close($conn);
        ?>
    </div>
</body>
<?php
  require_once "dashboard_script.html";
?>
</html>
