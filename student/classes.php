<?php
// Démarre la session PHP
session_start();

// Vérifie si l'utilisateur est connecté en tant qu'étudiant
if (!isset($_SESSION['student_id'])) {
    header("Location: welcome.php"); // Redirige vers la page d'accueil si non connecté
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <!-- Styles CSS -->
    <style>
        /* Style pour la carte principale */
        .card {
            display: flex;
            flex-direction: column;
            width: 1000px;
            margin: 10px auto;
            padding: 20px 50px;
            border: 2px solid #c4c4c4;
            border-radius: 20px;
            background: #D5D9EE;
            box-shadow: 9px 9px 30px #b0b0b0, -9px -9px 30px #ffffff;
        }

        /* Style pour les titres des cours */
        .card h2 {
            font-size: 35px;
            text-align: start;
            font-weight: 600;
            margin: 35px auto 10px auto;
            color: #010d24;
            text-transform: uppercase;
            text-shadow: 0 2px white, 0 3px #777;
        }

        /* Style pour la section du formulaire de recherche */
        .card .top {
            margin: 20px auto;
            width: 100%;
            padding: 20px;
        }

        /* Style pour le formulaire de recherche */
        .card .top form {
            width: 100%;
            display: flex;
            align-items: center;
        }

        .top form label {
            font-size: 18px;
            font-weight: 500;
            color: #000065;
            margin: auto 30px auto 0;
        }

        .top form .input {
            flex: 1;
            padding: 17px;
            border: 3px solid #000065;
            border-right: none;
            outline: none;
            border-top-left-radius: 50px;
            border-bottom-left-radius: 50px;
            color: #162155;
            background-color: #e8eafd;
            letter-spacing: 1.5px;
            font-size: 15px;
            box-shadow: inset 2px 2px 8px rgba(0, 0, 0, 0.5);
            transition: all 0.5s ease;
        }

        .top form .input:focus {
            letter-spacing: 2px;
            box-shadow: rgb(0 0 0 / 5%) 0 0 8px;
            background-color: white;
        }

        .top form .submit {
            padding: 17px 30px;
            border: 3px solid #000065;
            border-left: none;
            border-top-right-radius: 50px;
            border-bottom-right-radius: 50px;
            cursor: pointer;
            color: #162155;
            background-color: white;
            box-shadow: rgb(0 0 0 / 5%) 0 0 8px;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            font-size: 14px;
            transition: all 0.5s ease;
        }

        .top form .submit:hover {
            background-color: hsl(261deg 80% 48%);
            color: hsl(0, 0%, 100%);
            box-shadow: rgb(93 24 220) 0px 7px 29px 0px;
        }

        /* Style pour les sous-titres des cours */
        .card h3 {
            font-size: 23px;
            font-weight: 600;
            margin: 30px 0 0 0;
            color: #000046;
            text-transform: uppercase;
        }

        /* Style pour la section des cours */
        .card .classes {
            width: 90%;
            margin: 0 auto;
            padding: 25px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 25px;
            flex-wrap: wrap;
        }

        /* Style pour chaque cours individuel */
        .card .classes .cour {
            min-width: 150px;
            padding: 15px 25px;
            display: flex;
            align-items: center;
            background: #F0F0F0;
            box-shadow: 0px 1px 3px rgba(0, 0, 0, 0.2);
            border-radius: 9px;
            border-top: 5px solid #000046;
            border-bottom: 5px solid #000046;
            transition: .4s ease;
        }

        /* Style pour l'effet de survol sur chaque cours */
        .card .classes .cour:hover {
            transform: scale(1.1);
        }

        /* Style pour l'icône du cours */
        .card .classes .cour i {
            font-size: 35px;
            color: #000046;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 25px;
        }

        /* Style pour le lien vers le cours */
        .card .classes .cour a {
            text-decoration: none;
            font-size: 19px;
            font-weight: 500;
            color: #333;
            text-transform: uppercase;
        }
    </style>
    <!-- Encodage des caractères -->
    <meta charset="UTF-8">
    <!-- Inclusion du fichier CSS Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Viewport -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Inclusion du head du dashboard -->
    <?php
    require_once "dashbord_head.html";
    ?>
    <!-- Titre de la page -->
    <title>Cours</title>
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
                // Inclusion de la connexion à la base de données
                include_once "connection.php";

                // Requête pour récupérer les cours disponibles depuis la base de données
                $class_query = "SELECT * FROM classes";
                $class_result = mysqli_query($conn, $class_query);

                // Vérifie si la requête a été exécutée avec succès
                if (!$class_result) {
                    // Gestion de l'erreur de requête
                    echo "Erreur : " . mysqli_error($conn);
                    exit();
                }

                // Affichage des cours disponibles sous forme de liens
                if (mysqli_num_rows($class_result) > 0) {
                    echo "<h2>Cours disponibles pour l'inscription</h2>";
                    echo "<div class='top'>";

                    // Formulaire de recherche
                    echo "<form action='search_classes.php' method='GET'>";
                    echo "<label for='search'>Recherche :</label>";
                    echo "<input type='text' id='search' name='search' placeholder='Rechercher par nom ou mots-clés' class='input'>";
                    echo "<input type='submit' value='Rechercher' class='submit'>";
                    echo "</form>";
                    echo "<h3>Les Cours: </h3>";
                    echo "</div>";
                    echo "<div class='classes'>";
                    while ($class_row = mysqli_fetch_assoc($class_result)) {
                        echo "<div class='cour'>";
                        echo "<i class='fa-solid fa-square-plus'></i>";
                        echo "<a href='enroll_page.php?class_id=" . $class_row['id'] . "'>" . $class_row['class_name'] . "</a>";
                        echo "</div>";
                    }
                    echo "</div>";
                } else {
                    echo "Aucun cours disponible pour l'inscription.";
                }

                // Fermeture de la connexion à la base de données
                mysqli_close($conn);
                ?>
            </div>
        </div>
    </div>
</body>
<!-- Inclusion du script du tableau de bord -->
<?php
require_once "dashboard_script.html";
?>
</html>
