<?php
session_start();

// Check if the user is logged in as a student
if (!isset($_SESSION['student_id'])) {
  header("Location: my_classes.php"); // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
  exit();
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <style>
    .card {
      display: flex;
      flex-direction: column;
      width: 800px;
      margin: 10px auto;
      padding: 20px;
      border: 2px solid #c4c4c4;
      border-radius: 20px;
      background: #D5D9EE;
      box-shadow: 9px 9px 30px #b0b0b0,
        -9px -9px 30px #ffffff;
    }

    .card h2 {
      font-size: 35px;
      text-align: start;
      font-weight: 600;
      margin: 30px auto;
      color: #010d24;
      text-transform: uppercase;
      text-shadow: 0 2px white, 0 3px #777;
    }

    .message {
      font-size: 20px;
      font-weight: 500;
      padding: 25px;
      text-align: center;
      border-bottom: 2px solid #141D47;
      border-radius: 25px;
      box-shadow: 0 3px 5px rgba(0, 0, 0, 0.2);
    }

    .card h3 {
      margin: 0 auto 20px auto;
      font-size: 23px;
      font-weight: 600;
      text-transform: capitalize;
    }

    .card .message-sent {
      display: flex;
      width: 90%;
      flex-direction: column;
      align-items: start;
      background: #fff;
      padding: 20px;
      margin: 10px auto;
      border-radius: 20px;
      box-shadow: 4px 4px 12px rgba(0, 0, 0, 0.5);
    }

    .message-sent .date {
      background: #000036;
      color: #fff;
      padding: 13px;
      font-size: 15px;
      font-weight: 600;
      border-radius: 20px;
      margin-bottom: 20px;
      box-shadow: 2px 2px 9px rgba(0, 0, 0, 0.4);
    }

    .message-sent strong {
      background: #000036;
      color: #fff;
      padding: 13px;
      font-size: 15px;
      font-weight: 600;
      border-radius: 20px;
      margin-bottom: 20px;
      box-shadow: 2px 2px 9px rgba(0, 0, 0, 0.4);
    }

    .message-sent .date strong {
      margin-right: 20px;
    }

    .message-sent .text {
      width: 93%;
      margin: auto 40px;
      font-size: 18px;
      font-weight: 500;
    }
  </style>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php
  require_once "dashbord_head.html";
  ?>
  <title>Messages Envoyes</title>
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
        <?php

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
              echo "<h3>Messages envoyés : </h3>";
              while ($sent_message_row = mysqli_fetch_assoc($sent_messages_result)) {
                echo "<div class='message-sent'>";
                echo "<p class='date'><strong>Envoyé :</strong> " . $sent_message_row['sent_at'] . "</p>";
                echo "<strong>Message :</strong>";
                echo "<p class='text'>" . $sent_message_row['message_content'] . "</p>";
                echo "</div>";
              }
            } else {
              echo "<p class='message'>Aucun message n'a encore été envoyé.</p>";
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

      </div>
    </div>
  </div>
</body>
<?php
require_once "dashboard_script.html";
?>

</html>