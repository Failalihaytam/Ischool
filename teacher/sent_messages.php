<?php
session_start();

// Check if the user is logged in as a teacher
if (!isset($_SESSION['teacher_id'])) {
    header("Location: my_classes.php"); // Redirect to login page if not logged in
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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php
    require_once "dashbord_head.html";
    ?>
    <title>Les Messages Envoyés</title>
    <style>
        .card {
            max-width: 900px;
            margin: 50px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
<div class="container">
  <?php
    require_once "dashbord_body.html";
    ?>
    <div class="main">
      <div class="topbar">
        <div class="toggle">
          <ion-icon name="menu-outline"></ion-icon>
        </div>
      </div>
      <div class="card">
<h2>Les Messages Envoyés</h2>

<?php
        // Fetch messages and replies for this class
        $messages_query = "SELECT m.m_id AS message_id, m.sent_at, m.message_content, s.firstname, s.lastname, r.reply_message, r.replied_at
            FROM messages m
            INNER JOIN students s ON s.id = m.sender_id
            LEFT JOIN replies r ON r.message_id = m.m_id
            WHERE m.class_id = '$class_id' AND r.teacher_id = '" . $_SESSION['teacher_id'] . "'";
        $messages_result = mysqli_query($conn, $messages_query);

        if ($messages_result && mysqli_num_rows($messages_result) > 0) {
            while ($message_row = mysqli_fetch_assoc($messages_result)) {
?>
<div>
    <p><strong>De:</strong> <?php echo $message_row['firstname'] . " " . $message_row['lastname']; ?></p>
    <p><strong>Envoyé le:</strong> <?php echo $message_row['sent_at']; ?></p>
    <p><strong>Message:</strong> <?php echo $message_row['message_content']; ?></p>
    <?php if ($message_row['reply_message']) { ?>
    <p><strong>Réponse du Professeur:</strong> <?php echo $message_row['reply_message']; ?></p>
    <p><strong>Envoyé le:</strong> <?php echo $message_row['replied_at']; ?></p>
    <?php } else { ?>
    <p>Pas encore de réponse.</p>
    <?php } ?>
</div>
<?php
            }
        } else {
            echo "<p>Aucun message avec réponse trouvé.</p>";
        }
?>
</body>
<?php
  require_once "dashboard_script.html";
?>
</html>
<?php
    } else {
        echo "Classe introuvable ou vous n'êtes pas autorisé à voir les élèves de cette classe.";
    }
} else {
    echo "Requête invalide.";
}

// Close database connection
mysqli_close($conn);
?>
