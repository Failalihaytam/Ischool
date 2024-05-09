<?php
session_start();

// Check if the user is logged in as admin
if (!isset($_SESSION["username"])) {
  // Redirect to the login page if not logged in
  header("Location: admin_login.php");
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php
    require_once "dashbord_head.html";
  ?>
  <title>Welcome Admin</title>
  <style>
    h2 {
      margin-bottom: 20px;
      text-align: center;
    }

    p {
      margin-bottom: 10px;
    }

    .dashboard-links {
      margin-bottom: 20px;
    }

    .dashboard-links a {
      display: inline-block;
      margin: 5px;
      padding: 8px 15px;
      background-color: #007bff;
      color: #fff;
      text-decoration: none;
      border-radius: 5px;
    }

    .dashboard-links a:hover {
      background-color: #0056b3;
    }

    .logout {
      text-align: center;
      margin-top: 20px;
    }

    .logout a {
      color: #f44336;
      text-decoration: none;
    }

    .logout a:hover {
      text-decoration: underline;
    }
     .card {
      max-width: 900px;
      margin: 150px auto;
      padding: 20px;
      border: 1px solid #ccc;
      border-radius: 5px;
      box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
      text-align: center;
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
      <h2>Welcome Admin</h2>
    <p>You are now logged in as <?php echo $_SESSION["username"]; ?>.</p>

    <div class="dashboard-links">
      <a href="teacher_delete_requests.php">View Teacher Delete Requests</a>
      <a href="student_delete_requests.php">View Student Delete Requests</a>
    </div>

    <div class="logout">
      <a href="welcome.php">Back to Dashboard</a>
    </div>
    </div>
  </div>
  </div>
</body>
<?php
  require_once "dashboard_script.html";
?>
</html>
