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
      width: 1000px;
      margin: 10px auto;
      padding: 20px 50px;
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
      margin: 35px auto 10px auto;
      color: #010d24;
      text-transform: uppercase;
      text-shadow: 0 2px white, 0 3px #777;
    }

    .card .top {
      margin: 20px auto;
      width: 100%;
      padding: 20px;
    }

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

    .card h3 {
      font-size: 23px;
      font-weight: 600;
      margin: 30px 0 0 0;
      color: #000046;
      text-transform: uppercase;
    }

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

    .card .classes .cour:hover {
      transform: scale(1.1);
    }

    .card .classes .cour i {
      font-size: 35px;
      color: #000046;
      border-radius: 8px;
      display: flex;
      align-items: center;
      justify-content: center;
      margin-right: 25px;
    }

    .card .classes .cour a {
      text-decoration: none;
      font-size: 19px;
      font-weight: 500;
      color: #333;
      text-transform: uppercase;
    }

  </style>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php 
    require_once "dashbord_head.html";
  ?>
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
// Include database connection
include_once "connection.php";

// Fetch available classes from database
$class_query = "SELECT * FROM classes";
$class_result = mysqli_query($conn, $class_query);

// Check if query execution was successful
if (!$class_result) {
    // Handle query error
    echo "Erreur : " . mysqli_error($conn);
    exit();
}

// Display available classes as links
if (mysqli_num_rows($class_result) > 0) {
    echo "<h2>Cours disponibles pour l'inscription</h2>";
    echo "<div class='top'>";
    
    // Search form
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

