<?php
session_start();

// Check if the user is logged in as a student
if (!isset($_SESSION['student_id'])) {
    header("Location: my_classes.php"); // Redirect to login page if not logged in
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

        // Display form for sending messages
        echo "<h3>Envoyer un Message à l'Enseignant</h3>";
        echo "<form action='send_message.php' method='post'>";
        echo "<input type='hidden' name='class_id' value='" . $class_row['id'] . "'>";
        echo "<textarea name='message' placeholder='Tapez votre message ici' required></textarea><br>";
        echo "<input type='submit' value='Envoyer le Message'>";
        echo "</form>";
        echo "<a href='sent_messages.php?class_id=" . $class_row['id'] . "'>Messages Envoyés</a><br>";
        echo "<a href='inbox.php?class_id=" . $class_row['id'] . "'>Boîte de Réception</a><br>";

    } else {
        echo "Cours non trouvé ou vous n'avez pas la permission de voir ce cours.";
    }
} else {
    echo "Requête invalide.";
}

// Close database connection
mysqli_close($conn);
?>
