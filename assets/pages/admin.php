<?php
session_start();
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
        
        <?php include(dirname(__DIR__) . '/components/footer.php'); ?>
      </div>
    </div>
  </main>
</body>

</html>