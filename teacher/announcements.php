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

    // Fetch class details from database to display class name
    $class_query = "SELECT class_name FROM classes WHERE id = '$class_id' AND teacher_id = '" . $_SESSION['teacher_id'] . "'";
    $class_result = mysqli_query($conn, $class_query);
    $class_name = mysqli_fetch_assoc($class_result)['class_name'];

    if ($class_result && mysqli_num_rows($class_result) > 0) {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php
    require_once "dashbord_head.html";
    ?>
    <title>Annonces</title>
    <style>
        .card {
            max-width: 900px;
            margin: 50px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        textarea {
            width: 100%;
            height: 100px;
            resize: vertical;
            margin-bottom: 10px;
        }
        input[type="submit"] {
            cursor: pointer;
        }
        h2 {
            margin-bottom: 20px;
        }
        h3 {
            margin-top: 20px;
        }
        p {
            margin-bottom: 5px;
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

    <h2>Annonces du cours: <?php echo $class_name; ?></h2>

    <!-- Form to add new announcement -->
    <form method="POST" action="add_announcement.php">
        <input type="hidden" name="class_id" value="<?php echo $class_id; ?>">
        <textarea name="announcement" placeholder="Écrivez votre annonce ici..." required></textarea><br>
        <input type="submit" value="Ajouter l'annonce">
    </form>

    <?php
            // Check if form is submitted to add new announcement
            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['announcement'])) {
                $announcement = mysqli_real_escape_string($conn, $_POST['announcement']);

                // Insert new announcement into database
                $insert_query = "INSERT INTO announcements (class_id, announcement) VALUES ('$class_id', '$announcement')";
                if (mysqli_query($conn, $insert_query)) {
                    echo "<p>Annonce ajoutée avec succès!</p>";
                } else {
                    echo "<p>Erreur lors de l'ajout de l'annonce: " . mysqli_error($conn) . "</p>";
                }
            }

            // Fetch announcements for this class from database
            $announcements_query = "SELECT * FROM announcements WHERE class_id = '$class_id' ORDER BY created_at DESC";
            $announcements_result = mysqli_query($conn, $announcements_query);

            // Display existing announcements
            if ($announcements_result && mysqli_num_rows($announcements_result) > 0) {
                echo "<h3>Annonces existantes:</h3>";
                while ($announcement_row = mysqli_fetch_assoc($announcements_result)) {
                    echo "<p><strong>Posté le:</strong> " . $announcement_row['created_at'] . "</p>";
                    echo "<p>" . $announcement_row['announcement'] . "</p>";
                    echo "<hr>";
                }
            } else {
                echo "<p>Aucune annonce pour l'instant.</p>";
            }
    ?>
</div>
</body>
<?php
  require_once "dashboard_script.html";
?>
</html>
<?php
    } else {
        echo "Cours introuvable ou vous n'êtes pas autorisé à afficher les annonces de ce cours.";
    }
} else {
    echo "Requête invalide.";
}

// Close database connection
mysqli_close($conn);
?>
