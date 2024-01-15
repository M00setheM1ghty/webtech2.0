<?php
session_start();
$debug = false;
include(dirname(__DIR__) . '/components/hide_warnings.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include(dirname(__DIR__) . '/components/head.php'); ?>
</head>

<body>
    <?php include(dirname(__DIR__) . '/components/nav.php'); ?>
    <main>
        <div class="container">
            <div class="index-div">
                <div class="p-5 mb-4 bg-body-tertiary rounded-3">
                    <div class="container-fluid py-5">
                        <h1 class="display-5 fw-bold">News-Beiträge</h1>
                        <p class="col-md-8 fs-4">Aktuelles aus dem Hotel</p>
                    </div>
                    <!-- display News-Beiträge-->
                    <?php
                    require_once('../../assets/components/functions.php');
                    require_once('../../config/dbaccess.php');
                    // Fetch data from the database
                    $sql = "SELECT id, filename, thumbnail_path, description, uploaded_at FROM images ORDER BY uploaded_at DESC";
                    $result = $db_obj->query($sql);

                    // Check if there are results
                    if ($result->num_rows > 0) {
                        echo '<div class="container">';
                        echo '<div class="row">';

                        while ($row = $result->fetch_assoc()) {
                            echo '<div class="col-md-4 mb-4">';
                            echo '<div class="card">';
                            echo '<img src="' . $row['thumbnail_path'] . '" class="card-img-top" alt="' . $row['filename'] . '">';
                            echo '<div class="card-body">';
                            echo '<h5 class="card-title">' . $row['title'] . '</h5>';
                            echo '<p class="card-text">' . $row['description'] . '</p>';
                            echo '<p class="card-text"><small class="text-muted">Erstellt am: ' . $row['uploaded_at'] . '</small></p>';
                            echo '</div>';
                            echo '</div>';
                            echo '</div>';
                        }

                        echo '</div>';
                        echo '</div>';
                    } else {
                        echo '<p class="text-center">Keine Beiträge gefunden.</p>';
                    }

                    // Close the database connection
                    $db_obj->close();
                    ?>
                </div>
            </div>
    </main>
    <?php include(dirname(__DIR__) . '/components/footer.php'); ?>
</body>

</html>