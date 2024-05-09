<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION["username"])) {
  // Redirect to the login page if not logged in
  header("Location: admin_login.php");
  exit();
}

// Include database connection
include_once "connection.php";

// Fetch delete requests from the database
$query = "SELECT d.*, firstname, lastname FROM delete_requests d INNER JOIN teachers t ON t.id = d.user_id";
$result = mysqli_query($conn, $query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php
    require_once "dashbord_head.html";
  ?>
  <title>Delete Requests</title>
  <style>
    .card {
      max-width: 900px;
      margin: 50px auto;
      padding: 20px;
      border: 1px solid #ccc;
      border-radius: 5px;
      box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
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
    <h2>Delete Requests</h2>
    <table>
      <thead>
        <tr>
          <th>Full Name</th>
          <th>User Type</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
        <?php
        if ($result && mysqli_num_rows($result) > 0) {
          while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row['firstname'] . " " . $row['lastname'] . "</td>";
            echo "<td>" . $row['user_type'] . "</td>";
            echo "<td>" . $row['status'] . "</td>";
            echo "<td><a href='accept.php?request_id=" . $row['id'] . "&user_type=" . $row['user_type'] . "'>Accept</a></td>";
            echo "<td><a href='reject.php?request_id=" . $row['id'] . "&user_type=" . $row['user_type'] . "'>Reject</a></td>";
            echo "</tr>";
          }
        } else {
          echo "<tr><td colspan='5'>No delete requests found.</td></tr>";
        }
        ?>
      </tbody>
    </table>
  </div>
</body>
<?php
  require_once "dashboard_script.html";
?>
</html>
