<?php
// Include database connection
include_once "connection.php";

echo var_dump($_GET);
// Check if chapter_id is provided in the URL
if (isset($_GET['chapter_id']) && isset($_GET["class_id"])) {
    $chapter_id = $_GET['chapter_id'];
    $class_id = $_GET['class_id'];

    // Delete the chapter from the database
    $delete_query = "DELETE FROM chapters WHERE id = '$chapter_id'";
    if (mysqli_query($conn, $delete_query)) {
        header("Location: preview_chapters.php?class_id=".$class_id);
    } else {
        echo "Erreur lors de la suppression du chapitre: " . mysqli_error($conn);
    }

    // Close database connection
    mysqli_close($conn);
} else {
    echo "Requête invalide.";
}
?>
