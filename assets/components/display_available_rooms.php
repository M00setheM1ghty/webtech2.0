<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['show_rooms'])) {
    $chosen_checkin = $_POST['startDate'];
    $chosen_checkout = $_POST['endDate'];
    $_SESSION['startDate'] = $chosen_checkin;
    $_SESSION['endDate'] = $chosen_checkout;

    require_once('../../config/dbaccess.php');

    $get_available_rooms_query = "
    SELECT room_id, room_number, price_per_night
    FROM rooms
    WHERE room_id NOT IN (
        SELECT DISTINCT rr.room_id
        FROM reservation_rooms rr
        INNER JOIN reservations r ON rr.reservation_id = r.reservation_id
        WHERE (
              (r.start_date <= ? AND r.end_date >= ?)  -- Existing reservation starts or ends within the chosen time period
              OR
              (? <= r.start_date AND ? >= r.end_date)  -- Chosen time period starts or ends within an existing reservation
          )
    )";

    $get_available_rooms_stmt = $db_obj->prepare($get_available_rooms_query);
    $get_available_rooms_stmt->bind_param("ssss", $chosen_checkin, $chosen_checkout, $chosen_checkin, $chosen_checkout);
    $get_available_rooms_stmt->execute();
    $available_rooms_result = $get_available_rooms_stmt->get_result();
    ?>

    <!-- Form with checkboxes for available rooms -->
    <h3>Available Rooms</h3>

    <?php
    $available_rooms = array();

    while ($row = $available_rooms_result->fetch_assoc()) {
        $available_rooms[] = array(
            'room_id' => $row['room_id'],
            'room_number' => $row['room_number']
        );
    }
    $_SESSION['available_rooms'] = $available_rooms;

    if (isset($_SESSION['available_rooms'])) {
        $available_rooms = $_SESSION['available_rooms'];

        // Display the available rooms as checkboxes
        foreach ($available_rooms as $room) {
            echo '
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="selectedRooms[]" value="' . $room['room_number'] . '" id="room' . $room['room_id'] . '">
                <label class="form-check-label" for="room' . $room['room_id'] . '">
                    Room ' . $room['room_number'] . '
                </label>
            </div>';
        }
    } else {
        echo "No available rooms found.";
    }
    if ($debug) {
        var_dump($available_rooms);
    }

}
?>