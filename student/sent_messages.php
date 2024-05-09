<?php
session_start();

// Vérifie si l'utilisateur est connecté en tant qu'étudiant
if (!isset($_SESSION['student_id'])) {
    header("Location: my_classes.php"); // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
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

        // Récupère et affiche les messages envoyés par l'étudiant
        $sent_messages_query = "SELECT * FROM messages WHERE class_id = '$class_id' AND sender_id = '" . $_SESSION['student_id'] . "'";
        $sent_messages_result = mysqli_query($conn, $sent_messages_query);

        if ($sent_messages_result && mysqli_num_rows($sent_messages_result) > 0) {
            echo "<h3>Messages envoyés</h3>";
            while ($sent_message_row = mysqli_fetch_assoc($sent_messages_result)) {
                echo "<div>";
                echo "<p><strong>Envoyé :</strong> " . $sent_message_row['sent_at'] . "</p>";
                echo "<p><strong>Message :</strong> " . $sent_message_row['message_content'] . "</p>";
                echo "</div>";
            }
        } else {
            echo "<p>Aucun message n'a encore été envoyé.</p>";
        }
    } else {
        echo "Cours non trouvée ou vous n'avez pas l'autorisation de voir ce cours.";
    }
} else {
    echo "Demande invalide.";
}

// Ferme la connexion à la base de données
mysqli_close($conn);
?>
