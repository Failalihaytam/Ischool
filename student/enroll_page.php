<?php
session_start();

// Check if the user is logged in as a student
if (!isset($_SESSION['student_id'])) {
    header("Location: classes.php"); // Redirect to login page if not logged in
    exit();
}

// Include database connection
include_once "connection.php";

// Fetch available classes from database
$class_query = "SELECT * FROM classes";
$class_result = mysqli_query($conn, $class_query);

// Display available classes with additional information for enrollment
if (mysqli_num_rows($class_result) > 0) {

    // Check if the class ID is provided in the URL
    if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['class_id'])) {
        $clicked_class_id = $_GET['class_id'];

        // Fetch detailed information for the clicked class
        $detail_query = "SELECT * FROM classes WHERE id = '$clicked_class_id'";
        $detail_result = mysqli_query($conn, $detail_query);

        if ($detail_result && mysqli_num_rows($detail_result) > 0) {
            $class_row = mysqli_fetch_assoc($detail_result);
            echo "<h3>" . $class_row['class_name'] . "</h3>";
            echo "<p><strong>Enseignant :</strong> " . getTeacherName($class_row['teacher_id'], $conn) . "</p>";
            echo "<p><strong>Description :</strong> " . $class_row['description'] . "</p>";
            echo "<p><strong>Prérequis :</strong> " . $class_row['pre_requirements'] . "</p>";
            echo "<form method='post' action='enroll.php'>";
            echo "<input type='hidden' name='class_id' value='" . $class_row['id'] . "'>";
            echo "<input type='submit' value=\"S'inscrire\">";
            echo "</form>";
        } else {
            echo "Cours introuvable.";
        }
    } else {
        echo "Requête invalide.";
    }
} else {
    echo "Aucun cours disponible pour l'inscription.";
}

// Function to get teacher name
function getTeacherName($teacher_id, $conn) {
    $teacher_id = mysqli_real_escape_string($conn, $teacher_id);
    $query = "SELECT firstName, lastName FROM teachers WHERE id = '$teacher_id'";
    $result = mysqli_query($conn, $query);
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        return $row['firstName'] . " " . $row['lastName'];
    } else {
        return "Enseignant inconnu";
    }
}

// Close database connection
mysqli_close($conn);
?>
