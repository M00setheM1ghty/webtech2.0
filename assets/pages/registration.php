<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <?php include(dirname(__DIR__) . '/components/head.php'); ?>
</head>

<body>
  <?php
  error_reporting(E_ALL);
  ini_set('display_errors', 1);
  ?>
  <?php include(dirname(__DIR__) . '/components/nav.php'); ?>

  <main>

    <div class="container">
      <div class="p-5 mb-4 bg-body-tertiary rounded-3">
        <div class="container-fluid py-5">
          <h1 class="display-5 fw-bold">Hotel Hämmerle</h1>
          <p class="col-md-8 fs-4">Hier zur Registrierung für die Website:</p>
        </div>
      </div>
    </div>

    <div class="container">
      <?php include(dirname(__DIR__) . '/components/registration_form.php'); ?>
    </div>

    <?php include(dirname(__DIR__) . '/components/footer.php'); ?>

  </main>
</body>

</html>