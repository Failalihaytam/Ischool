<?php
session_start();

// Check if the user is logged in as a teacher
if (!isset($_SESSION['teacher_id'])) {
    header("Location: teacher_login.php"); // Redirect to login page if not logged in
    exit();
}

// Include database connection
include_once "connection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['visibility']) && isset($_POST['class_id'])) {
    $class_id = $_POST['class_id'];
    $visibility = $_POST['visibility']; // Array containing chapter IDs and their visibility status

    foreach ($visibility as $chapter_id => $status) {
        $update_query = "UPDATE chapters SET hidden = '$status' WHERE id = '$chapter_id' AND class_id = '$class_id'";
        mysqli_query($conn, $update_query);
    }

    header("Location: preview_chapters.php?class_id=".$class_id);
    exit();
} else {
    echo "Requête invalide.";
}

// Close database connection
mysqli_close($conn);
?>
