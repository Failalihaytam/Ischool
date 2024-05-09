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
            box-shadow: 9px 9px 30px #b0b0b0,
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

        .message {
            font-size: 20px;
            font-weight: 500;
            padding: 25px;
            text-align: center;
            border-bottom: 2px solid #141D47;
            border-radius: 25px;
            box-shadow: 0 3px 5px rgba(0, 0, 0, 0.2);
        }
    </style>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
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

                // Check if search term is provided
                if (isset($_GET['search'])) {
                    // Sanitize the search term to prevent SQL injection
                    $searchTerm = mysqli_real_escape_string($conn, $_GET['search']);

                    // Fetch classes from the database based on search term
                    $search_query = "SELECT * FROM classes WHERE class_name LIKE '%$searchTerm%' OR key_words LIKE '%$searchTerm%'";
                    $search_result = mysqli_query($conn, $search_query);

                    // Display search results as links to enroll
                    if ($search_result && mysqli_num_rows($search_result) > 0) {
                        echo "<h2>Résultats de la recherche</h2>";
                        echo "<div class='classes'>";
                        while ($row = mysqli_fetch_assoc($search_result)) {
                            echo "<div class='cour'>";
                            echo "<i class='fa-solid fa-book'></i>";
                            echo "<a href='enroll_page.php?class_id=" . $row['id'] . "'>" . $row['class_name'] . "</a><br>";
                            echo "</div>";
                        }
                        echo "</div>";
                    } else {
                        echo "<p class='message'>Aucun résultat trouvé.</p>";
                    }
                } else {
                    echo "<p class='message'>Aucun terme de recherche fourni.</p>";
                }

                // Close database connection
                mysqli_close($conn);
                ?>
            </div>
        </div>
    </div>
    </div>
</body>
<?php
require_once "dashboard_script.html";
?>

</html>
