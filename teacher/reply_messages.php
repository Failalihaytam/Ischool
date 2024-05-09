<?php
session_start();

// Check if the user is logged in as a teacher
if (!isset($_SESSION['teacher_id'])) {
    header("Location: my_classes.php"); // Redirect to appropriate page if not logged in
    exit();
}

// Include database connection
include_once "connection.php";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['class_id'], $_POST['reply_message'], $_POST['message_id'])) {
    $class_id = $_POST['class_id'];
    $reply_message = $_POST['reply_message'];
    $message_id = $_POST['message_id'];
    $teacher_id = $_SESSION['teacher_id'];

    // Insert the reply into the replies table
    $insert_query = "INSERT INTO replies (message_id, teacher_id, reply_message) VALUES ('$message_id', '$teacher_id', '$reply_message')";
    if (mysqli_query($conn, $insert_query)) {
        header("Location: messages.php?class_id=".$class_id);
    } else {
        echo "Erreur lors de l'envoi de la réponse : " . mysqli_error($conn);
    }
}

// Close database connection
mysqli_close($conn);
?>
