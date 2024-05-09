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

// Check if teacher ID is provided in the URL
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $teacher_id = $_GET['id'];

    // Fetch teacher details from database
    $query_teacher = "SELECT * FROM teachers WHERE id = '$teacher_id'";
    $result_teacher = mysqli_query($conn, $query_teacher);

    if ($result_teacher && mysqli_num_rows($result_teacher) > 0) {
        $row_teacher = mysqli_fetch_assoc($result_teacher);
        $firstName = $row_teacher['firstName'];
        $lastName = $row_teacher['lastName'];
        $email = $row_teacher['email'];
        // Add more fields if needed
    } else {
        echo "Teacher not found.";
        exit(); // Stop further execution
    }

    // Fetch classes taught by the teacher from database
    $query_classes = "SELECT class_name FROM classes WHERE teacher_id = '$teacher_id'";
    $result_classes = mysqli_query($conn, $query_classes);

    $classes = [];
    if ($result_classes && mysqli_num_rows($result_classes) > 0) {
        while ($row_classes = mysqli_fetch_assoc($result_classes)) {
            $classes[] = $row_classes['class_name'];
        }
    }
} else {
    echo "Invalid request.";
    exit(); // Stop further execution
}

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
  <title>Teacher Information</title>
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

    .teacher-details {
      margin-bottom: 20px;
    }

    .teacher-details p {
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
    <h2>Teacher Information</h2>

    <div class="teacher-details">
      <p><strong>ID:</strong> <?php echo $teacher_id; ?></p>
      <p><strong>First Name:</strong> <?php echo $firstName; ?></p>
      <p><strong>Last Name:</strong> <?php echo $lastName; ?></p>
      <p><strong>Email:</strong> <?php echo $email; ?></p>
      <?php if (!empty($classes)): ?>
        <p><strong>Classes Taught:</strong></p>
        <ul>
          <?php foreach ($classes as $class): ?>
            <li><?php echo $class; ?></li>
          <?php endforeach; ?>
        </ul>
      <?php endif; ?>
      <!-- Add more fields if needed -->
    </div>

    <a href="teachers.php">Back to Teachers List</a>
  </div>
</body>
<?php
  require_once "dashboard_script.html";
?>
</html>
