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
if (isset($_GET['class_id'])) {
    $class_id = $_GET['class_id'];

    // Récupère les détails de la classe depuis la base de données
    $class_query = "SELECT * FROM classes WHERE id = '$class_id'";
    $class_result = mysqli_query($conn, $class_query);

    // Affiche les détails de la classe
    if (mysqli_num_rows($class_result) == 1) {
        $class_row = mysqli_fetch_assoc($class_result);
        echo "<h2>" . $class_row['class_name'] . "</h2>";

        // Récupère les chapitres de la classe depuis la base de données
        $chapters_query = "SELECT * FROM chapters WHERE class_id = '$class_id'";
        $chapters_result = mysqli_query($conn, $chapters_query);

        // Affiche les chapitres
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

// Ferme la connexion à la base de données
mysqli_close($conn);
?>
