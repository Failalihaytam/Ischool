<?php
session_start();

// Check if the user is logged in as a student
if (!isset($_SESSION['student_id'])) {
  header("Location: welcome.php"); // Redirect to welcome page if not logged in
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
      font-size: 24px;
      font-weight: 600;
      margin: 10px 40px;
      color: #141D47;
    }

    .card .chapters {
      display: flex;
      align-items: center;
      justify-content: center;
      flex-wrap: wrap;
      gap: 20px;
      padding: 25px;
      width: 90%;
      margin: auto;
    }

    .card .chapters .chapter {
      min-width: 260px;
      background: #ADADAD;
      display: flex;
      flex-direction: column;
      align-items: center;
      padding: 15px;
      border-radius: 20px;
      box-shadow: 0 3px 8px rgba(0, 0, 0, 0.5);
    }

    .chapter .head {
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 30px;
      margin: 10px auto;
    }

    .chapter .head i {
      font-size: 28px;
      color: #141D47;
      background: #fff;
      border-radius: 20px;
      padding: 10px;
    }

    .chapter .head h4 {
      font-size: 22px;
      font-weight: 600; 
      color: #141D47;
    }

    .chapter a {
      text-decoration: none;
      padding: 17px 45px;
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
      margin: 20px auto;
    }

    .chapter a:hover {
      letter-spacing: 3px;
      background-color: hsl(261deg 80% 48%);
      color: hsl(0, 0%, 100%);
      box-shadow: rgb(93 24 220) 0px 7px 29px 0px;
    }
  </style>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
    integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <?php
  require_once "dashbord_head.html";
  ?>
  <title>Chapitres</title>
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

        // Check if class ID is provided in the URL
        if (isset($_GET['class_id'])) {
          $class_id = $_GET['class_id'];

          // Fetch class details from database
          $class_query = "SELECT * FROM classes WHERE id = '$class_id'";
          $class_result = mysqli_query($conn, $class_query);

          // Display class details
          if (mysqli_num_rows($class_result) == 1) {
            $class_row = mysqli_fetch_assoc($class_result);
            echo "<h2>" . $class_row['class_name'] . "</h2>";

            // Fetch chapters for the class from database
            $chapters_query = "SELECT * FROM chapters WHERE class_id = '$class_id'";
            $chapters_result = mysqli_query($conn, $chapters_query);

            // Display chapters
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