<?php
session_start();


// Check if the user is logged in
if (!isset($_SESSION["username"])) {
  // Redirect to the login page if not logged in
  header("Location: admin_login.php");
  exit();
}


?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php
    require_once "dashbord_head.html";
  ?>
  <style>
    .heading {
      width: 70%;
      margin: 200px auto;
    }

      .heading h1 {
    text-align: center;
    font-size:70px; font-weight:700; color:#222; letter-spacing:1px;
    text-transform: uppercase;

    display: grid;
    grid-template-columns: 1fr max-content 1fr;
    grid-template-rows: 27px 0;
    grid-gap: 20px;
    align-items: center;
}

.heading h1:after,.heading h1:before {
    content: " ";
    display: block;
    border-bottom: 3px solid #2a2185;
    border-top: 3px solid #2a2185;
    height: 20px;
  background-color:#f8f8f8;
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
      <div class="heading">
        <h1>Bienvenu</h1>
      </div>
    </div>
  </div>
</body>
<?php
  require_once "dashboard_script.html";
?>
</html>


