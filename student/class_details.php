<?php
session_start();

// Check if the user is logged in as a teacher
if (!isset($_SESSION['student_id'])) {
    header("Location: my_classes.php"); // Redirect to login page if not logged in
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
      box-shadow:  9px 9px 30px #b0b0b0,
                  -9px -9px 30px #ffffff;
    }

    .card h2 {
      font-size: 35px;
      text-align: start;
      font-weight: 600;
      margin: 30px auto 0 auto;
      color: #010d24;
      text-transform: uppercase;
      text-shadow: 0 2px white, 0 3px #777;
    }
    
    .card span {
      font-size: 28px;
      font-weight: 600;
      text-transform: uppercase;
      margin: 20px auto 0 auto;
      text-shadow: 0 2px white, 0 3px #777;
    }

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

    .card p:hover {
      transform: scale(1.05);
    }

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
    require_once "dashbord_head.html";
  ?>
  <title>Details du cours</title>
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
