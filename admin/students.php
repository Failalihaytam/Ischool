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

// Fetch list of students from the database
$query = "SELECT id, firstName, lastName FROM students";
$result = mysqli_query($conn, $query);

$students = [];
if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $students[] = $row;
    }
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
  <title>Students List</title>
  <style>
    body {
      font-family: Arial, sans-serif;
    }

    .card {
      max-width: 600px;
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

    .student-list {
      list-style-type: none;
      padding: 0;
    }

    .student-list li {
      margin-bottom: 10px;
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
        <h2>Students List</h2>

    <ul class="student-list">
      <?php foreach ($students as $student): ?>
        <li><a href="student_info.php?id=<?php echo $student['id']; ?>"><?php echo $student['firstName'] . ' ' . $student['lastName']; ?></a></li>
      <?php endforeach; ?>
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
