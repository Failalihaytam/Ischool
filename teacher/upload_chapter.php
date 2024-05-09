<?php
session_start();

// Check if the user is logged in as a teacher
if (!isset($_SESSION['teacher_id'])) {
    header("Location: teacher_upload_form.html"); // Redirect to login page if not logged in
    exit();
}

// Include database connection
include_once "connection.php";

// Check if the form is submitted and file is uploaded
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["chapter_file"]) && isset($_POST["chapter_name"]) && isset($_POST["class_id"])) {
    $teacher_id = $_SESSION['teacher_id'];
    $class_id = $_POST['class_id'];
    $chapter_name = $_POST['chapter_name'];
    $file_name = $_FILES["chapter_file"]["name"];
    $file_temp = $_FILES["chapter_file"]["tmp_name"];

    // Check if the file is a PDF
    $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
    if (strtolower($file_ext) != "pdf") {
        echo "Erreur : seuls les fichiers PDF sont autorisés.";
        exit();
    }

    // Upload the file
    $upload_dir = "uploads/";
    $file_path = $upload_dir . $file_name;
    if (move_uploaded_file($file_temp, $file_path)) {
        // Insert chapter information into the database
        $insert_query = "INSERT INTO chapters (class_id, chapter_name, file_path) VALUES ('$class_id', '$chapter_name', '$file_path')";
        if (mysqli_query($conn, $insert_query)) {
            header("Location: preview_chapters.php?class_id=".$class_id);
        } else {
            echo "Erreur lors de l'importation du chapitre :" . mysqli_error($conn);
        }
    } else {
        echo "Erreur lors de l'importation.";
    }
} else {
    echo "Requête invalide.";
}

// Close database connection
mysqli_close($conn);
?>
