<?php
session_start();
include_once "connection.php";

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: index.html"); // Redirect to login page if not logged in
    exit();
}

// Get student's email
$email = $_SESSION['email'];

// Insert delete request into the delete_requests table
$insertQuery = "INSERT INTO delete_requests (user_type, user_id) VALUES ('teacher', (SELECT id FROM teachers WHERE email = '$email'))";
$insertResult = mysqli_query($conn, $insertQuery);

if ($insertResult) {
    header("Location: index.html");
} else {
    echo "Erreur lors de l'envoi de la demande de suppression.";
}

mysqli_close($conn);
?>
