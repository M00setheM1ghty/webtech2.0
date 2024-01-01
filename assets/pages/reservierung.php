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
            <div class="container mt-5">
                <h2 class="mb-4">Zimmerreservierung</h2>
                <form id="reservationForm" action="process_reservation.php" method="post">
                    <!-- Email Input -->
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>

                    <!-- Reservation Period -->
                    <div class="form-group">
                        <label for="startDate">Start Date</label>
                        <input type="date" class="form-control" id="startDate" name="startDate" required>
                    </div>
                    <div class="form-group">
                        <label for="endDate">End Date</label>
                        <input type="date" class="form-control" id="endDate" name="endDate" required>
                    </div>

                    <!-- Additional Features -->
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="breakfast" name="breakfast">
                        <label class="form-check-label" for="breakfast">Include Breakfast</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="parking" name="parking">
                        <label class="form-check-label" for="parking">Include Parking</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="pets" name="pets">
                        <label class="form-check-label" for="pets">Include Pets</label>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-primary mt-3" name="submit-reservation">Submit Reservation</button>
                </form>
            </div>

            <?php include(dirname(__DIR__) . '/components/footer.php'); ?>
        </div>
        </div>
    </main>
</body>

</html>