<?php
session_start();

// Check if the user is logged in as a teacher
if (!isset($_SESSION['teacher_id'])) {
    header("Location: class_details.php"); // Redirect to login page if not logged in
    exit();
}

// Include database connection
include_once "connection.php";

// Check if the class ID is provided in the URL
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['class_id'])) {
    $class_id = $_GET['class_id'];

    // Fetch class details from database
    $class_query = "SELECT * FROM classes WHERE id = '$class_id' AND teacher_id = '" . $_SESSION['teacher_id'] . "'";
    $class_result = mysqli_query($conn, $class_query);

    if ($class_result && mysqli_num_rows($class_result) > 0) {
        $class_row = mysqli_fetch_assoc($class_result);
        echo "<h2>Les étudiants inscrits à ce cours " . $class_row['class_name'] . "</h2>";

        // Fetch enrolled students for the class from database
        $enrolled_query = "SELECT students.id, students.firstName, students.lastName FROM enrollment INNER JOIN students ON enrollment.student_id = students.id WHERE enrollment.class_id = '$class_id'";
        $enrolled_result = mysqli_query($conn, $enrolled_query);

        // Display enrolled students as links
        if (mysqli_num_rows($enrolled_result) > 0) {
            while ($enrolled_row = mysqli_fetch_assoc($enrolled_result)) {
                echo "<a href=''>" . $enrolled_row['firstName'] . " " . $enrolled_row['lastName'] . "</a><br>";
            }
        } else {
            echo "Aucun élève inscrit dans ce cours.";
        }
    } else {
        echo "Classe introuvable ou vous n'êtes pas autorisé à voir les élèves de cette classe.";
    }
} else {
    echo "Requête invalide.";
}

// Close database connection
mysqli_close($conn);
?>
