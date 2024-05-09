<?php
session_start();

// Check if the user is logged in as a student
if (!isset($_SESSION['student_id'])) {
    header("Location: my_classes.php"); // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
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
        echo "<h2>" . $class_row['class_name'] . "</h2>";

        // Fetch and display sent messages by the student
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
        echo "Classe non trouvée ou vous n'avez pas l'autorisation de voir cette classe.";
    }
} else {
    echo "Demande invalide.";
}

// Close database connection
mysqli_close($conn);
?>
