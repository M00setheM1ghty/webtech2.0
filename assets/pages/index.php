<?php
session_start();
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
            <h1 class="display-5 fw-bold">Hotel Hämmerle</h1>
            <p class="col-md-8 fs-4">Willkommen bei uns im schönen Lech am Arlberg!</p>
          </div>
        </div>
        <div class="slider">
          <div class="slide-track">
            <div class="slide">
              <img src="../images/slider1.jpg" height="400" width="600" alt="" />
            </div>
            <div class="slide">
              <img src="../images/slider2.jpg" height="400" width="600" alt="" />
            </div>
            <div class="slide">
              <img src="../images/slider3.jpg" height="400" width="600" alt="" />
            </div>
            <div class="slide">
              <img src="../images/slider4.jpg" height="400" width="600" alt="" />
            </div>
            <div class="slide">
              <img src="../images/slider1.jpg" height="400" width="600" alt="" />
            </div>
            <div class="slide">
              <img src="../images/slider2.jpg" height="400" width="600" alt="" />
            </div>
            <div class="slide">
              <img src="../images/slider3.jpg" height="400" width="600" alt="" />
            </div>
            <div class="slide">
              <img src="../images/slider4.jpg" height="400" width="600" alt="" />
            </div>
            <div class="slide">
              <img src="../images/slider1.jpg" height="400" width="600" alt="" />
            </div>
          </div>
        </div>
        <hr>
        <div class="container">
          <h2>Neuigkeiten</h2>
        </div>
        <hr>
        <?php include(dirname(__DIR__) . '/components/announcement.php'); ?>
      </div>
    </div>
    <?php include(dirname(__DIR__) . '/components/footer.php'); ?>
  </main>
</body>

</html>