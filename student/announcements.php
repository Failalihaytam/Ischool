<?php
session_start();

// Vérifie si l'utilisateur est connecté en tant qu'étudiant
if (!isset($_SESSION['student_id'])) {
    header("Location: welcome.php"); // Redirige vers la page d'accueil si non connecté
    exit();
}

// Inclut la connexion à la base de données
include_once "connection.php";

// Vérifie si l'ID de classe est fourni dans l'URL
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['class_id'])) {
    $class_id = $_GET['class_id'];

    // Récupère les détails de la classe depuis la base de données
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

        // Récupère les annonces pour l'ID de classe spécifié
        $announcements_query = "SELECT * FROM announcements WHERE class_id = '$class_id'";
        $announcements_result = mysqli_query($conn, $announcements_query);

        // Affiche les annonces
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

        echo "</div>"; // Ferme le conteneur
        echo "</body>";
        echo "</html>";
    } else {
        echo "Cours non trouvé ou vous n'avez pas la permission de voir les annonces pour ce cours.";
    }
} else {
    echo "Requête invalide.";
}

// Ferme la connexion à la base de données
mysqli_close($conn);
?>
