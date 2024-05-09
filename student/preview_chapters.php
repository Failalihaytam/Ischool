<?php
session_start();

// Vérifier si l'utilisateur est connecté en tant qu'étudiant
if (!isset($_SESSION['student_id'])) {
    header("Location: welcome.php"); // Rediriger vers la page d'accueil si non connecté
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <style>
        /* Styles CSS */
    </style>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <?php
    require_once "dashbord_head.html"; // Inclure le fichier de l'en-tête
    ?>
    <title>Chapitres</title>
</head>

<body>
    <div class="container">
        <?php
        require_once "dashbord_body.html"; // Inclure le corps de la page
        ?>
        <div class="main">
            <div class="topbar">
                <div class="toggle">
                    <ion-icon name="menu-outline"></ion-icon>
                </div>
            </div>
            <div class="card">
                <?php
                // Inclure la connexion à la base de données
                include_once "connection.php";

                // Vérifier si l'ID de la classe est fourni dans l'URL
                if (isset($_GET['class_id'])) {
                    $class_id = $_GET['class_id'];

                    // Récupérer les détails de la classe depuis la base de données
                    $class_query = "SELECT * FROM classes WHERE id = '$class_id'";
                    $class_result = mysqli_query($conn, $class_query);

                    // Afficher les détails de la classe
                    if (mysqli_num_rows($class_result) == 1) {
                        $class_row = mysqli_fetch_assoc($class_result);
                        echo "<h2>" . $class_row['class_name'] . "</h2>";

                        // Récupérer les chapitres de la classe depuis la base de données
                        $chapters_query = "SELECT * FROM chapters WHERE class_id = '$class_id'";
                        $chapters_result = mysqli_query($conn, $chapters_query);

                        // Afficher les chapitres
                        if (mysqli_num_rows($chapters_result) > 0) {
                            echo "<h3>Chapitres : </h3>";
                            echo "<div class='chapters'>";
                            while ($chapter_row = mysqli_fetch_assoc($chapters_result)) {
                                if ($chapter_row['hidden'] == 0) {
                                    echo "<div class='chapter'>";
                                    echo "<div class='head'>";
                                    echo "<i class='fa-solid fa-print'></i>";
                                    echo "<h4>" . $chapter_row['chapter_name'] . "</h4>";
                                    echo "</div>";
                                    // Lien pour voir le PDF
                                    echo "<a href='" . './../teacher/' . $chapter_row['file_path'] . "' target='_blank'>Voir le PDF</a>";
                                    echo "</div>";
                                }
                            }
                            echo "</div>";
                        } else {
                            echo "<p class='message'>Aucun chapitre disponible</p>";
                        }
                    } else {
                        echo "Cours non trouvé.";
                    }
                } else {
                    echo "Requête invalide.";
                }

                // Fermer la connexion à la base de données
                mysqli_close($conn);
                ?>
            </div>
        </div>
    </div>
</body>
<?php
require_once "dashboard_script.html"; // Inclure le script de la page
?>

</html>
