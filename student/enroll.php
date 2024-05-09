<?php
session_start();

// Check if the user is logged in as a student
if (!isset($_SESSION['student_id'])) {
    header("Location: classes.php"); // Redirect to welcome page if not logged in
    exit();
}

// Include database connection
include_once "connection.php";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['class_id'])) {
    $class_id = $_POST['class_id'];
    $student_id = $_SESSION['student_id'];
    // Check if the student is already enrolled in the class
    $check_sql = "SELECT * FROM enrollment WHERE student_id = '$student_id' AND class_id = '$class_id'";
    $check_result = mysqli_query($conn, $check_sql);

    if (mysqli_num_rows($check_result) > 0) {
        echo "Vous êtes déjà inscrit dans cette classe.";
    } else {
        // Enroll the student in the class
        $enroll_sql = "INSERT INTO enrollment (student_id, class_id) VALUES ('$student_id', '$class_id')";
        if (mysqli_query($conn, $enroll_sql)) {
            echo "Inscription réussie !";
            header("Location: welcome.php");
        } else {
            echo "Error: " . $enroll_sql . "<br>" . mysqli_error($conn);
        }
    }
}

// Close database connection
mysqli_close($conn);
?>
