<?php
// Include database connection
include_once "connection.php";

// Check if search term is provided
if (isset($_GET['search'])) {
    // Sanitize the search term to prevent SQL injection
    $searchTerm = mysqli_real_escape_string($conn, $_GET['search']);

    // Fetch classes from the database based on search term
    $search_query = "SELECT * FROM classes WHERE class_name LIKE '%$searchTerm%' OR key_words LIKE '%$searchTerm%'";
    $search_result = mysqli_query($conn, $search_query);

    // Display search results as links to enroll
    if ($search_result && mysqli_num_rows($search_result) > 0) {
        echo "<h2>Résultats de la recherche</h2>";
        while ($row = mysqli_fetch_assoc($search_result)) {
            echo "<a href='enroll_page.php?class_id=" . $row['id'] . "'>" . $row['class_name'] . "</a><br>";
        }
    } else {
        echo "Aucun résultat trouvé.";
    }
} else {
    echo "Aucun terme de recherche fourni.";
}

// Close database connection
mysqli_close($conn);
?>
