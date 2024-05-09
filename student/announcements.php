<?php
session_start();

// Check if the user is logged in as a student
if (!isset($_SESSION['student_id'])) {
    header("Location: welcome.php"); // Redirect to welcome page if not logged in
    exit();
}

// Include database connection
include_once "connection.php";

// Check if the class ID is provided in the URL
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['class_id'])) {
    $class_id = $_GET['class_id'];

    // Fetch class details from database
    $class_query = "SELECT * FROM classes WHERE id = '$class_id'";
    $class_result = mysqli_query($conn, $class_query);

    if ($class_result && mysqli_num_rows($class_result) > 0) {
        $class_row = mysqli_fetch_assoc($class_result);
        echo "<!DOCTYPE html>";
        echo "<html lang='fr'>";
        echo "<head>";
        echo "<meta charset='UTF-8'>";
        echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'>";
        echo "<title>Annonces de " . $class_row['class_name'] . "</title>";
        echo "<style>";
        echo "body { font-family: Arial, sans-serif; background-color: #f2f2f2; }";
        echo ".container { max-width: 800px; margin: 20px auto; padding: 20px; background-color: #fff; border-radius: 10px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); }";
        echo "h2 { color: #333; }";
        echo ".announcement { margin-bottom: 20px; padding: 10px; background-color: #f9f9f9; border-left: 4px solid #3498db; }";
        echo ".announcement p { margin: 5px 0; }";
        echo ".posted { font-size: 12px; color: #666; }";
        echo "</style>";
        echo "</head>";
        echo "<body>";
        echo "<div class='container'>";
        echo "<h2>Annonces de " . $class_row['class_name'] . "</h2>";

        // Fetch announcements for the specified class ID
        $announcements_query = "SELECT * FROM announcements WHERE class_id = '$class_id'";
        $announcements_result = mysqli_query($conn, $announcements_query);

        // Display announcements
        if ($announcements_result && mysqli_num_rows($announcements_result) > 0) {
            while ($announcement_row = mysqli_fetch_assoc($announcements_result)) {
                echo "<div class='announcement'>";
                echo "<p><strong>Publié :</strong> <span class='posted'>" . $announcement_row['created_at'] . "</span></p>";
                echo "<p>" . $announcement_row['announcement'] . "</p>";
                echo "</div>";
            }
        } else {
            echo "<p>Aucune annonce pour le moment.</p>";
        }

        echo "</div>"; // Close container
        echo "</body>";
        echo "</html>";
    } else {
        echo "Cours non trouvé ou vous n'avez pas la permission de voir les annonces pour ce cours.";
    }   
} else {
    echo "Requête invalide.";
}

// Close database connection
mysqli_close($conn);
?>
