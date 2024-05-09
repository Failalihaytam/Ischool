<?php
session_start();

// Check if the user is logged in as a teacher
if (!isset($_SESSION['teacher_id'])) {
    header("Location: teacher_login.php"); // Redirect to login page if not logged in
    exit();
}

// Include database connection
include_once "connection.php";

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['chapter_id']) && isset($_POST['class_id'])) {
    $chapter_id = $_POST['chapter_id'];
    $new_chapter_name = $_POST['new_chapter_name'];
    $file_name = $_FILES["new_chapter_file"]["name"];
    $file_temp = $_FILES["new_chapter_file"]["tmp_name"];
    $class_id = $_POST['class_id'];

    // Check if the file is a PDF
    $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
    if (strtolower($file_ext) != "pdf") {
        echo "Erreur : seuls les fichiers PDF sont autorisés.";
        exit();
    }

    // Upload the new file
    $upload_dir = "uploads/";
    $file_path = $upload_dir . $file_name;
    if (move_uploaded_file($file_temp, $file_path)) {
        // Update chapter information in the database
        $update_query = "UPDATE chapters SET chapter_name = '$new_chapter_name', file_path = '$file_path' WHERE id = '$chapter_id'";
        if (mysqli_query($conn, $update_query)) {
            echo "Chapitre importé avec succès!";
            header("Location: preview_chapters.php?class_id=".$class_id);
        } else {
            echo "Erreur lors de l'importation du chapitre: " . mysqli_error($conn);
        }
    } else {
        echo "Erreur lors de l'importation.";
    }
} else {
    // Include HTML form if no form submission
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php
    require_once "dashbord_head.html";
    ?>
    <title>Importer Un Chapitre</title>
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
    <h2>Importer Un Chapitre</h2>
    <form action="update_chapter.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="chapter_id" value="<?php echo $_GET['chapter_id']; ?>">
        <input type="hidden" name="class_id" value="<?php echo $_GET['class_id']; ?>"> <!-- Get chapter_id from URL -->
        <label for="new_chapter_name">Intitulé Du Chapitre:</label>
        <input type="text" id="new_chapter_name" name="new_chapter_name" required><br><br>

        <label for="new_chapter_file">Importer Un PDF:</label>
        <input type="file" id="new_chapter_file" name="new_chapter_file" accept=".pdf" required><br><br>

        <input type="submit" value="Importer">
    </form>
</div>
</body>
<?php
  require_once "dashboard_script.html";
?>
</html>
<?php
}

// Close database connection
mysqli_close($conn);
?>
