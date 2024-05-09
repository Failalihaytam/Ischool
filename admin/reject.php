<?php
session_start();

// Check if the user is logged in as admin
if (!isset($_SESSION["username"])) {
  // Redirect to the admin login page if not logged in
  header("Location: admin_login.php");
  exit();
}

// Include database connection
include_once "connection.php";

// Check if delete request ID is provided
if (isset($_GET['request_id'])) {
  $request_id = $_GET['request_id'];

  // Delete the delete request from the delete_requests table
  $deleteQuery = "DELETE FROM delete_requests WHERE id = '$request_id'";
  $deleteResult = mysqli_query($conn, $deleteQuery);

  if ($deleteResult) {
        header("Location: delete_requests.php");
      } else {
    echo "Error deleting delete request.";
  }
} else {
  echo "Invalid request.";
}

// Close database connection
mysqli_close($conn);
?>
