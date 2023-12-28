<?php
session_start();
$user_role = 'anonymous';
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
            <h1 class="display-5 fw-bold">Hotel Hämmerle</h1>
            <p class="col-md-8 fs-4">Willkommen bei uns im schönen Lech am Arlberg!</p>
          </div>
        </div>
        <hr>
        <div class="container">
          <h2>News und Aktuelles</h2>
        </div>
        <hr>
        <?php include(dirname(__DIR__) . '/components/news/winterSaisonStart.php'); ?>
        <?php include(dirname(__DIR__) . '/components/news/festivitaeten.php'); ?>
        <?php include(dirname(__DIR__) . '/components/news/schneeInLech.php'); ?>
        <?php include(dirname(__DIR__) . '/components/news/MarcGusner.php'); ?>

        <?php include(dirname(__DIR__) . '/components/footer.php'); ?>
      </div>
    </div>
    <?php
        require_once('../../config/dbaccess.php');
        $db_obj = new mysqli($servername, $username, $password, $database);

        if ($db_obj->connect_error) {
            echo "Connection Error: " . $db_obj->connect_error;
            exit();
        }
        ?>
  </main>
</body>

</html>