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
        echo "<h2>Chapitres</h2>";
        echo "<form action='update_chapter_visibility.php' method='post'>";
        echo "<div>";
        while ($chapter_row = mysqli_fetch_assoc($chapters_result)) {
            echo "<div class='chapter'>";
            if ($chapter_row['hidden'] == 0)
            {
                echo "<h3>" . $chapter_row['chapter_name'] . "</h3>";
            }
            else
            {
                echo "<h3>" . $chapter_row['chapter_name'] . " (Invisible)</h3>";
            }

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
        echo "</div>";
        echo "</form>";
    } else {
        echo "Aucun chapitre disponible.";
    }

    // Close database connection
    mysqli_close($conn);
} else {
    echo "Requête invalide.";
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <style>
        .chapter {
            background: #fdfdfd;
            width: 200px;
            height: 200px;
            border-radius: 19px;
        }
    </style>
</body>
</html>
