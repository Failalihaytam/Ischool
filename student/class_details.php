<?php
session_start();

// Vérifie si l'utilisateur est connecté en tant qu'enseignant
if (!isset($_SESSION['student_id'])) {
    // Redirige vers la page de connexion si non connecté
    header("Location: my_classes.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <style>
    /* Styles pour la carte */
    .card {
      display: flex;
      flex-direction: column;
      width: 800px;
      margin: 10px auto;
      padding: 20px;
      border: 2px solid #c4c4c4;
      border-radius: 20px;
      background: #D5D9EE;
      box-shadow:  9px 9px 30px #b0b0b0,
                  -9px -9px 30px #ffffff;
    }

    /* Styles pour le titre */
    .card h2 {
      font-size: 35px;
      text-align: start;
      font-weight: 600;
      margin: 30px auto 0 auto;
      color: #010d24;
      text-transform: uppercase;
      text-shadow: 0 2px white, 0 3px #777;
    }

    /* Styles pour les sous-titres */
    .card span {
      font-size: 28px;
      font-weight: 600;
      text-transform: uppercase;
      margin: 20px auto 0 auto;
      text-shadow: 0 2px white, 0 3px #777;
    }

    /* Styles pour le paragraphe */
    .card p {
      width: 450px;
      background: #FCFCFC;
      text-align: center;
      font-size: 20px;
      font-weight: 600;
      color: #162155;
      margin: 10px auto 30px auto;
      padding: 20px;
      border-radius: 12px;
      border-radius: 20px;
      box-shadow:  9px 9px 30px #b0b0b0;
      line-height: 30px;
      letter-spacing: 1px;
      transition: .5s ease;
    }

    /* Styles pour le paragraphe lors du survol */
    .card p:hover {
      transform: scale(1.05);
    }

    /* Styles pour les liens */
    .card a {
      text-decoration: none;
      margin: 8px auto;
      padding: 17px 40px;
      border-radius: 50px;
      cursor: pointer;
      border: 0;
      color: #162155;
      background-color: white;
      box-shadow: rgb(0 0 0 / 5%) 0 0 8px;
      letter-spacing: 1.5px;
      text-transform: uppercase;
      font-size: 15px;
      transition: all 0.5s ease;
    }

    /* Styles pour les liens lors du survol */
    .card a:hover {
      letter-spacing: 3px;
      background-color: hsl(261deg 80% 48%);
      color: hsl(0, 0%, 100%);
      box-shadow: rgb(93 24 220) 0px 7px 29px 0px;
    }
  </style>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php
    require_once "dashbord_head.html"; // Inclut le contenu du head
  ?>
  <title>Details du cours</title>
</head>
<body>
  <div class="container">
    <?php
      require_once "dashbord_body.html"; // Inclut le contenu du body
    ?>
    <div class="main">
      <div class="topbar">
        <div class="toggle">
          <ion-icon name="menu-outline"></ion-icon>
        </div>
      </div>
      <div class="card">
      <?php
        // Inclut la connexion à la base de données
        include_once "connection.php";

        // Vérifie si l'ID du cours est fourni dans l'URL
        if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['class_id'])) {
            $class_id = $_GET['class_id'];

            // Récupère les détails du cours depuis la base de données
            $class_query = "SELECT * FROM classes WHERE id = '$class_id'";
            $class_result = mysqli_query($conn, $class_query);

            if ($class_result && mysqli_num_rows($class_result) > 0) {
                $class_row = mysqli_fetch_assoc($class_result);
                echo "<h2>" . $class_row['class_name'] . "</h2>";
                echo "<span>Description : </span></br>";
                echo "<p>" . $class_row['description'] ."</p>";
                echo "<a href='preview_chapters.php?class_id=" . $class_row['id'] . "'>Chapitres</a><br>";
                echo "<a href='announcements.php?class_id=" . $class_row['id'] . "'>Annonces</a><br>";
                echo "<a href='messages.php?class_id=" . $class_row['id'] . "'>Messages</a><br>";
            } else {
                echo "Cours non trouvé ou vous n'avez pas la permission de voir ce cours.";
            }
        } else {
            echo "Requête invalide.";
        }

        // Ferme la connexion à la base de données
        mysqli_close($conn);
        ?>

      </div>
    </div>
  </div>
</body>
<?php
  require_once "dashboard_script.html"; // Inclut le script JavaScript
?>
</html>
