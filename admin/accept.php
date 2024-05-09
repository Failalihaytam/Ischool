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
if (isset($_GET['request_id']) && isset($_GET['user_type'])) {
  $request_id = $_GET['request_id'];
  $user_type = $_GET['user_type'] . "s";

  // Delete the student's account based on the delete request ID
  $deleteQuery = "DELETE FROM $user_type WHERE id = (SELECT user_id FROM delete_requests WHERE id = '$request_id')";
  $deleteResult = mysqli_query($conn, $deleteQuery);

  if ($deleteResult) {
    // Delete the delete request from the delete_requests table
    $deleteRequestQuery = "DELETE FROM delete_requests WHERE id = '$request_id'";
    $deleteRequestResult = mysqli_query($conn, $deleteRequestQuery);

    if ($deleteRequestResult) {
      header("Location: delete_requests.php");
    } else {
      echo "Error deleting delete request.";
    }
  } else {
    echo "Error deleting account.";
  }
} else {
  echo "Invalid request.";
}

// Close database connection
mysqli_close($conn);
?>
