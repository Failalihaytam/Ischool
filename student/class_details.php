<?php
session_start();

// Vérifie si l'utilisateur est connecté en tant qu'enseignant
if (!isset($_SESSION['student_id'])) {
    header("Location: my_classes.php"); // Redirige vers la page de connexion si non connecté
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
        echo "<h2>" . $class_row['class_name'] . "</h2>";
        echo "<p><strong>Description :</strong> " . $class_row['description'] . "</p>";

        // Liens
        echo "<a href='preview_chapters.php?class_id=" . $class_row['id'] . "'>Chapitres</a><br>";
        echo "<a href='announcements.php?class_id=" . $class_row['id'] . "'>Annonces</a><br>";
        echo "<a href='messages.php?class_id=" . $class_row['id'] . "'>Messages</a><br>";
    } else {
        echo "Cours non trouvé ou vous n'avez pas la permission de voir ce cours.";
    }
} else {
    echo "Requête invalide.";
}

// Ferme la connexion à la base de données
mysqli_close($conn);
?>
