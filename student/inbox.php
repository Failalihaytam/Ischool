<?php
session_start();

// Check if the user is logged in as a student
if (!isset($_SESSION['student_id'])) {
    header("Location: my_classes.php"); // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
    exit();
}

include_once "connection.php";

// Check if the class ID is provided in the URL
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['class_id'])) {
    $class_id = $_GET['class_id'];

    // Fetch messages and replies from the database
    $messages_query = "SELECT messages.*, replies.reply_message, replies.replied_at
                      FROM messages
                      LEFT JOIN replies ON messages.m_id = replies.message_id
                      WHERE messages.class_id = '$class_id' AND messages.sender_id = '{$_SESSION['student_id']}'";
    $messages_result = mysqli_query($conn, $messages_query);

    if ($messages_result && mysqli_num_rows($messages_result) > 0) {
        while ($row = mysqli_fetch_assoc($messages_result)) {
            echo "<div style='margin: 50px 20px;'>";
            echo "<p><strong>Votre message :</strong> " . $row['message_content'] . "</p>";
            echo "<strong>Envoyé à : " . $row['sent_at'] ."</strong>";
            echo "<p><strong>Réponse du professeur :</strong> " . $row['reply_message'] . "</p>";
            echo "<strong>Répondu à : " . $row['replied_at'] ."</strong>";
            echo "</div>";
        }
    } else {
        echo "Aucun message ou réponse trouvé.";
    }
} else {
    echo "Requête invalide.";
}

// Close database connection
mysqli_close($conn);
?>
