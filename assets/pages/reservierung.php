<?php
session_start();
//declare variables
$reservation_success = "";
$email = $_SESSION['email'];
// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $startDate = $_POST['startDate'];
    $endDate = $_POST['endDate'];
    $breakfast = isset($_POST['breakfast']) ? 1 : 0;
    $parking = isset($_POST['parking']) ? 1 : 0;
    $pets = isset($_POST['pets']) ? 1 : 0;
    $startDate = $_POST['startDate'];
    $endDate = $_POST['endDate'];

    //check if dates are correct and do confirm to minimum stay of 2 days
    $startDateTime = new DateTime($startDate);
    $endDateTime = new DateTime($endDate);

    // Calculate the minimum end date (start date + 2 days)
    $minEndDate = $startDateTime->modify('+2 days')->format('Y-m-d');

    // Check if the selected end date is at least 2 days after the start date
    if ($endDateTime < $startDateTime) {
        // Handle error: Minimum booking time not met
        echo "Error: The minimum booking time is 2 days. Please select an end date at least 2 days after the start date.";
        exit;
    }

    // Get selected rooms
    $selectedRooms = isset($_POST['rooms']) ? $_POST['rooms'] : [];

    // Now you can process each selected room
    require_once('../../config/dbaccess.php');

    // Retrieve `user_id` based on provided email from `user_profil` table
    $selectUserIdQuery = "SELECT `user_id` FROM `user_profil` WHERE `email` = ?";
    $stmtSelectUserId = $db_obj->prepare($selectUserIdQuery);
    $stmtSelectUserId->bind_param("s", $email);
    $stmtSelectUserId->execute();
    $stmtSelectUserId->bind_result($userId);
    $stmtSelectUserId->fetch();
    $stmtSelectUserId->close();

    // Insert into `reservations` table
    $insertReservationQuery = "INSERT INTO `reservations` (`user_id`, `start_date`, `end_date`, `breakfast`, `parking`, `pets`) 
                                VALUES (?, ?, ?, ?, ?, ?)";
    $stmtReservation = $db_obj->prepare($insertReservationQuery);
    $stmtReservation->bind_param("isssii", $userId, $startDate, $endDate, $breakfast, $parking, $pets);
    $stmtReservation->execute();

    // Get the generated reservation_id -> autoincremented value
    $reservationId = $stmtReservation->insert_id;
    $stmtReservation->close();

    // Insert into `reservation_rooms` table for each selected room
    foreach ($selectedRooms as $roomNumber) {
        $insertReservationRoomQuery = "INSERT INTO `reservation_rooms` (`reservation_id`, `room_id`) 
                                        VALUES (?, ?)";
        $stmtReservationRoom = $db_obj->prepare($insertReservationRoomQuery);

        // Retrieve `room_id` based on `room_number`
        $selectRoomIdQuery = "SELECT `room_id` FROM `rooms` WHERE `room_number` = ?";
        $stmtSelectRoomId = $db_obj->prepare($selectRoomIdQuery);
        $stmtSelectRoomId->bind_param("i", $roomNumber);
        $stmtSelectRoomId->execute();
        $stmtSelectRoomId->bind_result($roomId);
        $stmtSelectRoomId->fetch();
        $stmtSelectRoomId->close();

        // Insert into `reservation_rooms`
        $stmtReservationRoom->bind_param("ii", $reservationId, $roomId);
        $stmtReservationRoom->execute();
        $stmtReservationRoom->close();
    }

    // Redirect or show success message
    $reservation_success = "Reservierung wurde abgeschickt.";
}
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
                <form id="reservationForm" action="reservierung.php" method="post">
                    <!-- Email Input -->
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email"
                            value="<?php echo isset($_SESSION['email']) ? $_SESSION['email'] : ''; ?>" required>
                    </div>
                    <!-- Room Selection -->
                    <div class="form-group mt-3">
                        <label>Room Selection</label><br>
                        <?php
                        // Display checkboxes for rooms
                        for ($roomNumber = 101; $roomNumber <= 110; $roomNumber++) {
                            echo '<div class="form-check form-check-inline">';
                            echo '<input type="checkbox" class="form-check-input" id="room' . $roomNumber . '" name="rooms[]" value="' . $roomNumber . '">';
                            echo '<label class="form-check-label" for="room' . $roomNumber . '">Room ' . $roomNumber . '</label>';
                            echo '</div>';
                        }
                        ?>
                    </div>
                    <!-- Reservation Period -->
                    <!-- min value is set to 3 days after current date -->
                    <!-- max value is set to 1 year after current date -->
                    <div class="form-group">
                        <label for="startDate">Start Date</label>
                        <input type="date" class="form-control" id="startDate" name="startDate" min="<?php echo date('Y-m-d', strtotime('+3 days')); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="endDate">End Date</label>
                        <input type="date" class="form-control" id="endDate" name="endDate" min="<?php echo date('Y-m-d', strtotime('+5 days')); ?>" max="<?php echo date('Y-m-d', strtotime('+1 year')); ?>" required>
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
                    <button type="submit" class="btn btn-primary mt-3" name="submit-reservation">Submit
                        Reservation</button>
                    <?php
                    if (isset($reservation_success)) {
                        echo $reservation_success;
                    }
                    ?>
                </form>
            </div>

            <?php include(dirname(__DIR__) . '/components/footer.php'); ?>
        </div>
        </div>
    </main>
</body>

</html>