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
    <title>Boîte de réception</title>
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

<h2>Boîte de réception</h2>

    <?php
            // Fetch messages from students for this class
            $messages_query = "SELECT * FROM messages m
            INNER JOIN students s ON s.id = m.sender_id
            WHERE class_id = '$class_id'";
            $messages_result = mysqli_query($conn, $messages_query);

            if ($messages_result && mysqli_num_rows($messages_result) > 0) {
                while ($message_row = mysqli_fetch_assoc($messages_result)) {
    ?>
<div>
    <p><strong>De:</strong> <?php echo $message_row['firstname'] . " " . $message_row['lastname']; ?></p>
    <p><strong>Envoyé le:</strong> <?php echo $message_row['sent_at']; ?></p>
    <p><strong>Message:</strong> <?php echo $message_row['message_content']; ?></p>
    <form action='reply_messages.php' method='post'>
        <input type='hidden' name='class_id' value='<?php echo $class_id; ?>'>
        <input type='hidden' name='message_id' value='<?php echo $message_row['m_id']; ?>'>
        <input type='hidden' name='student_id' value='<?php echo $message_row['sender_id']; ?>'>
        <textarea name='reply_message' placeholder='Répondre à l'étudiant' required></textarea><br>
        <input type='submit' value='Envoyer la réponse'>
    </form>
</div>
<?php
            }
        } else {
            echo "<p>Aucun message dans la boîte de réception.</p>";
        }
?>
</body>
<?php
  require_once "dashboard_script.html";
?>
</html>
<?php
    } else {
        echo "Cours introuvable ou vous n'êtes pas autorisé à afficher ce cours.";
    }
} else {
    echo "Requête invalide.";
}

// Close database connection
mysqli_close($conn);
?>
