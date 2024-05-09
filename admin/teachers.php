<?php
session_start();

// Check if the user is logged in as admin
if (!isset($_SESSION["username"])) {
  // Redirect to the login page if not logged in
  header("Location: admin_login.php");
  exit();
}

// Include database connection
include_once "connection.php";

// Fetch teachers' information from the database
$query = "SELECT * FROM teachers";
$result = mysqli_query($conn, $query);

// Close database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php
    require_once "dashbord_head.html";
  ?>
  <title>View Teachers</title>
  <style>
    body {
      font-family: Arial, sans-serif;
    }

    .card {
      max-width: 900px;
      margin: 50px auto;
      padding: 20px;
      border: 1px solid #ccc;
      border-radius: 5px;
      box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    }

    h2 {
      margin-bottom: 20px;
      text-align: center;
    }

    .teacher-list {
      list-style-type: none;
      padding: 0;
    }

    .teacher-list li {
      margin-bottom: 10px;
    }

    .teacher-link {
      color: #007bff;
      text-decoration: none;
    }

    .teacher-link:hover {
      text-decoration: underline;
    }
  </style>
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
    <h2>View Teachers</h2>

    <ul class="teacher-list">
      <?php
      if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
          echo "<li>";
          echo "<a href='teacher_info.php?id=" . $row['id'] . "' class='teacher-link'>" . $row['firstName'] . " " . $row['lastName'] . "</a>";
          echo "</li>";
        }
      } else {
        echo "<li>No teachers found.</li>";
      }
      ?>
    </ul>

    <a href="welcome.php">Back to Dashboard</a>
  </div>
    </div>
  </div>
</body>
<?php
  require_once "dashboard_script.html";
?>
</html>
