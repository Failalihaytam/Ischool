<?php
// Include database connection
include_once "connection.php";

// Check if class_id is provided in the URL
if (isset($_GET['class_id'])) {
    $class_id = $_GET['class_id'];

    // Fetch chapters for the specified class ID
    $chapters_query = "SELECT * FROM chapters WHERE class_id = '$class_id'";
    $chapters_result = mysqli_query($conn, $chapters_query);

    // Display chapters
    if (mysqli_num_rows($chapters_result) > 0) {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php
    require_once "dashbord_head.html";
    ?>
    <title>Chapitres</title>
    <style>
        .card {
            max-width: 900px;
            margin: 50px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        .chapter {
            background: #fdfdfd;
            width: 200px;
            height: 200px;
            border-radius: 19px;
            margin-bottom: 20px;
            padding: 10px;
        }
        .chapter h3 {
            margin-top: 0;
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
    <h2>Chapitres</h2>
    <form action='update_chapter_visibility.php' method='post'>
        <div>
            <?php
                    while ($chapter_row = mysqli_fetch_assoc($chapters_result)) {
                        echo "<div class='chapter'>";
                        echo "<h3>" . $chapter_row['chapter_name'] . ($chapter_row['hidden'] ? " (Invisible)" : "") . "</h3>";
                        echo "<a href='" . $chapter_row['file_path'] . "' target='_blank'>Afficher le PDF</a><br/>"; // Link to view PDF
                        echo "<select name='visibility[" . $chapter_row['id'] . "]'>";
                        echo "<option value='0'>Rendre Visible</option>"; // Default to show
                        echo "<option value='1'>Rendre Invisible</option>";
                        echo "</select>";
                        echo "<input type='hidden' name='class_id' value='" . $class_id . "'>"; // Hidden input for class ID
                        echo "<input type='submit' value='Appliquer'>";
                        echo "<a href='delete_chapter.php?chapter_id=" . $chapter_row['id'] . "&class_id=".$class_id."'>Supprimer</a><br>";
                        echo "<a href='update_chapter.php?chapter_id=" . $chapter_row['id'] . "&class_id=".$class_id."'>Modifier</a><br>";
                        echo "</div>";
                    }
            ?>
        </div>
    </form>
</div>
</body>
<?php
  require_once "dashboard_script.html";
?>
</html>
<?php
    } else {
        echo "Aucun chapitre disponible.";
    }

    // Close database connection
    mysqli_close($conn);
} else {
    echo "Requête invalide.";
}
?>
