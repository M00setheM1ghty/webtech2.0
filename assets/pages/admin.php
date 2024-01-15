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
                        <h1 class="display-5 fw-bold">Admin Seite</h1>
                        <p class="col-md-8 fs-4">Userverwaltung, Reservierungseinsicht, News-Beiträge</p>
                    </div>
                    <!-- display user list and master data change form (display userlist included in change_masterdata.php)-->
                    <?php include(dirname(__DIR__) . '/components/calculate_total_charge.php'); ?>
                    <?php include(dirname(__DIR__) . '/components/change_masterdata.php'); ?>
                    <?php include(dirname(__DIR__) . '/components/admin_reservations_display.php'); ?>
                </div>
            </div>
            <?php include(dirname(__DIR__) . '/components/footer.php'); ?>
    </main>
</body>

</html>