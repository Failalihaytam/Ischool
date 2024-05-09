<?php
session_start();

// Check if the user is logged in as a teacher
if (!isset($_SESSION['teacher_id'])) {
    header("Location: teacher_login.php"); // Redirect to login page if not logged in
    exit();
}

// Include database connection
include_once "connection.php";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['class_id']) && isset($_POST['announcement'])) {
    $class_id = $_POST['class_id'];
    $announcement = $_POST['announcement'];

    // Insert the announcement into the database
    $insert_query = "INSERT INTO announcements (class_id, announcement) VALUES ('$class_id', '$announcement')";
    if (mysqli_query($conn, $insert_query)) {
        header("Location: announcements.php?class_id=$class_id"); // Redirect to announcements page
        exit();
    } else {
        echo "Erreur lors de l'ajout de l'annonce : " . mysqli_error($conn);
    }
} else {
    echo "Requête invalide.";
}

// Close database connection
mysqli_close($conn);
?>
