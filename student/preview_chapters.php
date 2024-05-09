<?php
session_start();

// Check if the user is logged in as a student
if (!isset($_SESSION['student_id'])) {
    header("Location: welcome.php"); // Redirect to welcome page if not logged in
    exit();
}

// Include database connection
include_once "connection.php";

// Check if class ID is provided in the URL
if (isset($_GET['class_id'])) {
    $class_id = $_GET['class_id'];

    // Fetch class details from database
    $class_query = "SELECT * FROM classes WHERE id = '$class_id'";
    $class_result = mysqli_query($conn, $class_query);

    // Display class details
    if (mysqli_num_rows($class_result) == 1) {
        $class_row = mysqli_fetch_assoc($class_result);
        echo "<h2>" . $class_row['class_name'] . "</h2>";

        // Fetch chapters for the class from database
        $chapters_query = "SELECT * FROM chapters WHERE class_id = '$class_id'";
        $chapters_result = mysqli_query($conn, $chapters_query);

        // Display chapters
        if (mysqli_num_rows($chapters_result) > 0) {
            echo "<h3>Chapitres</h3>";
            while ($chapter_row = mysqli_fetch_assoc($chapters_result)) {
                if ($chapter_row['hidden'] == 0) {
                    echo "<div>";
                    echo "<h4>" . $chapter_row['chapter_name'] . "</h4>";
                    echo "<a href='" .'./../teacher/'. $chapter_row['file_path'] . "' target='_blank'>Voir le PDF</a>";
                    echo "</div>";
                }
            }
        } else {
            echo "Aucun chapitre disponible.";
        }
    } else {
        echo "Cours non trouvé.";
    }
} else {
    echo "Requête invalide.";
}

// Close database connection
mysqli_close($conn);
?>
