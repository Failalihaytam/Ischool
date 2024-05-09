<?php
session_start();

// Check if the user is logged in as a student
if (!isset($_SESSION['student_id'])) {
    header("Location: classes.php"); // Redirect to login page if not logged in
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
      margin: 40px auto;
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
      font-size: 20px;
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
      margin: 10px auto 10px auto;
      padding: 15px;
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

    .card form {
      margin: 30px auto;
      width: 100%;
      text-align: center;
    }

    .card .submit {
      text-decoration: none;
      width: 70%;
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


    .card .submit:hover {
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
  <title>Inscription au cours</title>
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

// Fetch available classes from database
$class_query = "SELECT * FROM classes";
$class_result = mysqli_query($conn, $class_query);

// Display available classes with additional information for enrollment
if (mysqli_num_rows($class_result) > 0) {

    // Check if the class ID is provided in the URL
    if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['class_id'])) {
        $clicked_class_id = $_GET['class_id'];

        // Fetch detailed information for the clicked class
        $detail_query = "SELECT * FROM classes WHERE id = '$clicked_class_id'";
        $detail_result = mysqli_query($conn, $detail_query);

        if ($detail_result && mysqli_num_rows($detail_result) > 0) {
            $class_row = mysqli_fetch_assoc($detail_result);
            echo "<h2>" . $class_row['class_name'] . "</h2>";
            echo "<span>Enseignant :</span> ";
            echo "<p>". getTeacherName($class_row['teacher_id'], $conn) . "</p>";
            echo "<span>Description :</span>";
            echo "<p>" . $class_row['description'] . "</p>";
            echo "<span>Prérequis :</span>";
            echo "<p>". $class_row['pre_requirements'] . "</p>";
            echo "<form method='post' action='enroll.php'>";
            echo "<input type='hidden' name='class_id' value='" . $class_row['id'] . "'>";
            echo "<input class='submit' type='submit' value=\"S'inscrire\">";
            echo "</form>";
        } else {
            echo "Cours introuvable.";
        }
    } else {
        echo "Requête invalide.";
    }
} else {
    echo "Aucun cours disponible pour l'inscription.";
}

// Function to get teacher name
function getTeacherName($teacher_id, $conn) {
    $teacher_id = mysqli_real_escape_string($conn, $teacher_id);
    $query = "SELECT firstName, lastName FROM teachers WHERE id = '$teacher_id'";
    $result = mysqli_query($conn, $query);
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        return $row['firstName'] . " " . $row['lastName'];
    } else {
        return "Enseignant inconnu";
    }
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

