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

// Check if class ID is provided in the URL
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $class_id = $_GET['id'];

    // Fetch class details from the database
    $query_class = "SELECT c.class_name, c.description, c.key_words, c.pre_requirements, t.firstName AS teacher_firstName, t.lastName AS teacher_lastName
                    FROM classes c
                    INNER JOIN teachers t ON c.teacher_id = t.id
                    WHERE c.id = '$class_id'";
    $result_class = mysqli_query($conn, $query_class);

    if ($result_class && mysqli_num_rows($result_class) > 0) {
        $row_class = mysqli_fetch_assoc($result_class);
        $class_name = $row_class['class_name'];
        $description = $row_class['description'];
        $key_words = $row_class['key_words'];
        $pre_requirements = $row_class['pre_requirements'];
        $teacher_name = $row_class['teacher_firstName'] . " " . $row_class['teacher_lastName'];
    } else {
        echo "Class not found.";
        exit(); // Stop further execution
    }

    // Fetch enrolled students for the class
    $query_students = "SELECT s.firstName, s.lastName FROM enrollment e INNER JOIN students s ON e.student_id = s.id WHERE e.class_id = '$class_id'";
    $result_students = mysqli_query($conn, $query_students);

    $students = [];
    if ($result_students && mysqli_num_rows($result_students) > 0) {
        while ($row_students = mysqli_fetch_assoc($result_students)) {
            $students[] = $row_students['firstName'] . " " . $row_students['lastName'];
        }
    }

    // Fetch chapters for the class
    $query_chapters = "SELECT * FROM chapters WHERE class_id = '$class_id'";
    $result_chapters = mysqli_query($conn, $query_chapters);

    $chapters = [];
    if ($result_chapters && mysqli_num_rows($result_chapters) > 0) {
        while ($row_chapters = mysqli_fetch_assoc($result_chapters)) {
            $chapters[] = $row_chapters;
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
  <title>Class Information</title>
  <style>
    body {
      font-family: Arial, sans-serif;
    }

    .card {
      max-width: 800px;
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

    .class-details {
      margin-bottom: 20px;
    }

    .class-details p {
      margin-bottom: 10px;
    }

    .enrolled-students {
      margin-bottom: 20px;
    }

    .enrolled-students ul {
      list-style-type: none;
      padding: 0;
    }

    .enrolled-students li {
      margin-bottom: 5px;
    }

    .chapters-list {
      margin-bottom: 20px;
    }

    .chapters-list .chapter {
      margin-bottom: 10px;
      border: 1px solid #ccc;
      padding: 10px;
      border-radius: 5px;
    }

    .chapters-list .chapter h3 {
      margin-bottom: 5px;
    }

    .chapters-list .chapter p {
      margin-bottom: 5px;
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
    <h2>Class Information</h2>

    <div class="class-details">
      <p><strong>Class Name:</strong> <?php echo $class_name; ?></p>
      <p><strong>Teacher:</strong> <?php echo $teacher_name; ?></p>
      <p><strong>Description:</strong> <?php echo $description; ?></p>
      <p><strong>Keywords:</strong> <?php echo $key_words; ?></p>
      <p><strong>Prerequisites:</strong> <?php echo $pre_requirements; ?></p>
    </div>

    <div class="enrolled-students">
      <h3>Enrolled Students:</h3>
      <ul>
        <?php foreach ($students as $student): ?>
          <li><?php echo $student; ?></li>
        <?php endforeach; ?>
      </ul>
    </div>

    <div class="chapters-list">
      <h3>Chapters:</h3>
      <?php foreach ($chapters as $chapter): ?>
        <div class="chapter">
          <h3><?php echo $chapter['chapter_name']; ?></h3>
          <p>Content: <a target="_blank" href="../teacher/<?php echo $chapter['file_path']; ?>">View PDF</a></p>
          <p>Created At: <?php echo $chapter['created_at']; ?></p>
        </div>
      <?php endforeach; ?>
    </div>

    <a href="classes.php">Back to Classes List</a>
  </div>
</body>
<?php
  require_once "dashboard_script.html";
?>
</html>
