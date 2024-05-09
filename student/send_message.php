<?php
session_start();

// Check if the user is logged in as a student
if (!isset($_SESSION['student_id'])) {
    header("Location: my_classes.php"); // Redirect to login page if not logged in
    exit();
}

// Include database connection
include_once "connection.php";

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['class_id']) && isset($_POST['message'])) {
    $class_id = $_POST['class_id'];
    $message = $_POST['message'];
    $student_id = $_SESSION['student_id'];

    // Insert message into database
     $insert_query = "INSERT INTO messages (sender_id, class_id, message_content) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($conn, $insert_query);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "iis", $_SESSION['student_id'], $class_id, $message);
        if (mysqli_stmt_execute($stmt)) {
            header("Location: messages.php?class_id=" .$class_id);
        } else {
            echo "Erreur lors de l'envoi du message : " . mysqli_stmt_error($stmt);
        }
        mysqli_stmt_close($stmt);
    } else {
        echo "Erreur de préparation de la requête : " . mysqli_error($conn);
    }
     
} else {
    echo "Requête invalide.";
}

// Close database connection
mysqli_close($conn);
?>
