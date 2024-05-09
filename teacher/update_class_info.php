<?php
session_start();

// Check if the user is logged in as a teacher
if (!isset($_SESSION['teacher_id'])) {
    header("Location: teacher_login.php"); // Redirect to login page if not logged in
    exit();
}

// Include database connection
include_once "connection.php";

// Check if class_id is provided in the URL
if (isset($_GET['class_id'])) {
    $class_id = $_GET['class_id'];

    // Fetch class information for the specified class ID
    $class_query = "SELECT * FROM classes WHERE id = '$class_id'";
    $class_result = mysqli_query($conn, $class_query);
    if ($class_result && mysqli_num_rows($class_result) > 0) {
        $class_row = mysqli_fetch_assoc($class_result);
        $class_name = $class_row['class_name'];
        $description = $class_row['description'];
        $key_words = $class_row['key_words'];
        $pre_requirements = $class_row['pre_requirements'];
        // Other class information

        // Check if form is submitted for updating class info
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['class_name']) && isset($_POST['description']) && isset($_POST['key_words']) && isset($_POST['pre_requirements'])) {
            $new_class_name = $_POST['class_name'];
            $new_description = $_POST['description'];
            $new_key_words = $_POST['key_words'];
            $new_pre_requirements = $_POST['pre_requirements'];
            // Update class information in the database
            $update_query = "UPDATE classes SET class_name = '$new_class_name', description = '$new_description', key_words = '$new_key_words', pre_requirements = '$new_pre_requirements' WHERE id = '$class_id'";
            if (mysqli_query($conn, $update_query)) {
                echo "Les informations du cours ont été mises à jour avec succès!";
                // Redirect to class details page or any other page as needed
                header("Location: class_details.php?class_id=" . $class_id);
                exit();
            } else {
                echo "Erreur lors de la mise à jour des informations du cours: " . mysqli_error($conn);
            }
        }

        // Display the form for updating class information
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <?php
             require_once "dashbord_head.html";
            ?>
            <title>Mettre à jour les informations du cours</title>
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
            <h2>Mettre à jour les informations du cours</h2>
            <form action="" method="post">
                <label for="class_name">Intitulé Du Cours:</label>
                <input type="text" id="class_name" name="class_name" value="<?php echo $class_name; ?>" required><br><br>

                <label for="description">Description:</label><br>
                <textarea id="description" name="description" rows="4" cols="50" required><?php echo $description; ?></textarea><br><br>

                <label for="key_words">Mots Clés:</label>
                <input type="text" id="key_words" name="key_words" value="<?php echo $key_words; ?>" required><br><br>

                <label for="pre_requirements">Les Prérequis:</label><br>
                <textarea id="pre_requirements" name="pre_requirements" rows="4" cols="50" required><?php echo $pre_requirements; ?></textarea><br><br>

                <!-- Add other input fields for updating class info as needed -->

                <input type="submit" value="Mettre à jour">
            </form>
        </div>
        </body>
        <?php
             require_once "dashboard_script.html";
        ?>
        </html>
        <?php
    } else {
        echo "Cours Introuvable.";
    }

    // Close database connection
    mysqli_close($conn);
} else {
    echo "Requête invalide.";
}
?>
