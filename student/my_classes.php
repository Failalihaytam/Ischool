<?php
session_start();

// Check if the user is logged in as a student
if (!isset($_SESSION['student_id'])) {
    header("Location: welcome.php"); // Redirect to welcome page if not logged in
    exit();
}

// Include database connection
include_once "connection.php";

// Get student ID from session
$student_id = $_SESSION['student_id'];

// Fetch enrolled classes for the student from database
$enrolled_query = "SELECT classes.id, classes.class_name FROM enrollment INNER JOIN classes ON enrollment.class_id = classes.id WHERE enrollment.student_id = '$student_id'";
$enrolled_result = mysqli_query($conn, $enrolled_query);

// Display enrolled classes as links
if (mysqli_num_rows($enrolled_result) > 0) {
    echo "<h2>Vos Cours</h2>";
    while ($enrolled_row = mysqli_fetch_assoc($enrolled_result)) {
        echo "<a href='class_details.php?class_id=" . $enrolled_row['id'] . "'>" . $enrolled_row['class_name'] . "</a><br>";
    }
} else {
    echo "Vous n'êtes inscrit à aucun cours.";
}

// Close database connection
mysqli_close($conn);
?>
