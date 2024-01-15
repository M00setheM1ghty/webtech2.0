<?php
$debug = true;
session_start();
require_once('../components/functions.php');
// create token and store in session
if (!isset($_SESSION['reservation_token'])) {
    $_SESSION['reservation_token'] = setToken();
}
//declare variables
$reservation_success = "";
$email = $_SESSION['email'];


// Check if the form is submitted
if (
    $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reservation_token']) &&
    $_POST['reservation_token'] === $_SESSION['reservation_token'] && isset($_POST['submit-reservation'])
) {
    // Get form data
    $startDate = $_SESSION['startDate'];
    $endDate = $_SESSION['endDate'];
    $breakfast = isset($_POST['breakfast']) ? 1 : 0;
    $parking = isset($_POST['parking']) ? 1 : 0;
    $pets = isset($_POST['pets']) ? 1 : 0;
    $person_amount = $_POST['person_amount'];
    ;

    //check if dates are correct and confirm to minimum stay of 2 days
    $startDateTime = new DateTime($startDate);
    $endDateTime = new DateTime($endDate);

    // Calculate the minimum end date (start date + 2 days)
    $minEndDate = $startDateTime->modify('+2 days')->format('Y-m-d');

    // Check if the selected end date is at least 2 days after the start date
    if ($endDateTime < $startDateTime) {
        echo "Der minimale Buchungszeitraum sind 2 Tage.";
        exit();
    }

    // process data and add to db
    require_once('../../config/dbaccess.php');

    // get `user_id` with email from `user_profil` table
    $selectUserIdQuery = "SELECT `user_id` FROM `user_profil` WHERE `email` = ?";
    $stmtSelectUserId = $db_obj->prepare($selectUserIdQuery);
    $stmtSelectUserId->bind_param("s", $email);
    $stmtSelectUserId->execute();
    $stmtSelectUserId->bind_result($userId);
    $stmtSelectUserId->fetch();
    $stmtSelectUserId->close();

    // insert into table
    $insertReservationQuery = "INSERT INTO `reservations` (`user_id`, `start_date`, `end_date`, `breakfast`, `parking`, `pets`, `person_amount`) 
                                VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmtReservation = $db_obj->prepare($insertReservationQuery);
    $stmtReservation->bind_param("isssiii", $userId, $startDate, $endDate, $breakfast, $parking, $pets, $person_amount);
    $stmtReservation->execute();

    // get reservation_id -> autoincremented value to add to reservation_rooms table
    $reservationId = $stmtReservation->insert_id;
    $stmtReservation->close();

    // add to `reservation_rooms` table for each selected room
    foreach ($_POST['selectedRooms'] as $roomNumber) {
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
        //reset token
        $_SESSION['$reservation_token'] = setToken();
    }
    // success msg
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
                <!-- Reservation Period -->
                <!-- min value is set to 3 days after current date -->
                <!-- max value is set to 1 year after current date -->
                <form action="reservierung.php" method="post" id="display-rooms-form">
                    <div class="form-group">
                        <label for="startDate">Anfang</label>
                        <input type="date" class="form-control" id="startDate" name="startDate"
                            min="<?php echo date('Y-m-d', strtotime('+3 days')); ?>" value="<?php if (isset($_SESSION['startDate'])) {
                                    echo $_SESSION['startDate'];
                                } ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="endDate">Ende</label>
                        <input type="date" class="form-control" id="endDate" name="endDate"
                            min="<?php echo date('Y-m-d', strtotime('+5 days')); ?>"
                            max="<?php echo date('Y-m-d', strtotime('+1 year')); ?>" value="<?php if (isset($_SESSION['endDate'])) {
                                    echo $_SESSION['endDate'];
                                } ?>" required>
                    </div>
                    <button type="submit" class="btn btn-primary mt-3" name="show_rooms">Zeige verfügbare
                        Zimmer</button>

                </form>
                <?php if (isset($room_error_msg))
                    echo $room_error_msg; ?>

                <!-- Reservation-form -->
                <form id="reservationForm" action="reservierung.php" method="post">
                    <?php include(dirname(__DIR__) . '/components/display_available_rooms.php'); ?>
                    <!-- Email  -->
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email"
                            value="<?php echo isset($_SESSION['email']) ? $_SESSION['email'] : ''; ?>" readonly
                            required>
                    </div>
                    <!-- personenanzahl -->
                    <div class="form-group">
                        <label for="person_amount">Anzahl Personen</label>
                        <input type="number" class="form-control" id="person_amount" name="person_amount" max=8
                            required>
                    </div>
                    <!-- Additional Features -->
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="breakfast" name="breakfast">
                        <label class="form-check-label" for="breakfast">+ Frühstück (10 Euro pro Person)</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="parking" name="parking">
                        <label class="form-check-label" for="parking">+ Parkplatz (20 Euro pauschal)</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="pets" name="pets">
                        <label class="form-check-label" for="pets">+ Haustiere (50 Euro pauschal)</label>
                    </div>

                    <!-- Submit Button -->
                    <input type="hidden" name="reservation_token" value="<?php echo $_SESSION['reservation_token']; ?>">
                    <button type="submit" class="btn btn-primary mt-3" name="submit-reservation">Submit
                        Reservation</button>
                    <!-- echo successful reservation submission-->
                    <?php
                    if (isset($reservation_success)) {
                        echo $reservation_success;
                    }
                    ?>
                </form>
                <!------------------------------------end of reservation form ------------------------------------------------->
            </div>

            <div class="container mt-5">
                <h2 class="mb-4">Aktuelle Reservierungen</h2>
                <!-- table with current reservation data -->
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Reservierungsnummer</th>
                                <th>Checkin</th>
                                <th>Checkout</th>
                                <th>Frühstück</th>
                                <th>Parkplatz</th>
                                <th>Haustiere</th>
                                <th>Status</th>
                                <th>Personen</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Fetch reservations for the current user based on email
                            require_once('../../config/dbaccess.php');
                            $get_reservations_query = "
                            SELECT `reservation_id`, `user_id`, `start_date`, `end_date`,
                            `breakfast`, `parking`, `pets`, `reservation_status`, `person_amount`
                            FROM `reservations`
                            WHERE `user_id` IN (SELECT `user_id` FROM `user_profil` WHERE `email` = ?)";
                            $fetch_data = $db_obj->prepare($get_reservations_query);
                            $fetch_data->bind_param("s", $email);
                            $fetch_data->execute();
                            // put results in an assoc array
                            $fetched_data_array = $fetch_data->get_result();

                            if ($debug) {
                                if ($fetch_data->error) {
                                    echo "Query error: " . $fetch_data->error;
                                }

                            }
                            // Loop through reservations and display in the table
                            while ($row = $fetched_data_array->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>{$row['reservation_id']}</td>";
                                echo "<td>" . date("Y-m-d", strtotime($row['start_date'])) . "</td>";
                                echo "<td>" . date("Y-m-d", strtotime($row['end_date'])) . "</td>";
                                echo "<td>{$row['breakfast']}</td>";
                                echo "<td>{$row['parking']}</td>";
                                echo "<td>{$row['pets']}</td>";
                                echo "<td>{$row['reservation_status']}</td>";
                                echo "<td>{$row['person_amount']}</td>";
                                echo "</tr>";
                            }
                            if ($debug) {
                                echo "Session variables:";
                                var_dump($_SESSION);
                            }
                            ?>
                        </tbody>
                    </table>
                </div>

            </div>
            <?php include(dirname(__DIR__) . '/components/footer.php'); ?>
        </div>
        </div>
    </main>
</body>

</html>