<?php
$debug = false;
require_once('../../config/dbaccess.php');
require_once('../../assets/components/functions.php');
// Assuming $db_obj is your database connection object

// Fetch all rows from the combined tables
$query = "
    SELECT 
        r.`reservation_id`, r.`user_id`, r.`start_date`, r.`end_date`,
        r.`breakfast`, r.`parking`, r.`pets`, r.`reservation_status`, r.`person_amount`,
        u.`vorname`, u.`nachname`, u.`email`, ro.`price_per_night`,
        GROUP_CONCAT(ro.`room_number` ORDER BY ro.`room_number` ASC) AS `room_numbers`,
        GROUP_CONCAT(ro.`price_per_night` ORDER BY ro.`price_per_night` ASC) AS `room_prices`
    FROM 
        `reservations` r
    INNER JOIN 
        `user_profil` u ON r.`user_id` = u.`user_id`
    INNER JOIN 
        `reservation_rooms` rr ON r.`reservation_id` = rr.`reservation_id`
    INNER JOIN 
        `rooms` ro ON rr.`room_id` = ro.`room_id`
    GROUP BY
        r.`reservation_id`, r.`user_id`, r.`start_date`, r.`end_date`,
        r.`breakfast`, r.`parking`, r.`pets`, r.`reservation_status`, r.`person_amount`,
        u.`vorname`, u.`nachname`, u.`email`";

$result = $db_obj->query($query);

// Check if the query was successful
if ($result) {
    while ($row = $result->fetch_assoc()) {
        if ($debug) {
            echo "Processing reservation with ID: " . $row['reservation_id'] . "<br>";
            echo "User: {$row['vorname']} {$row['nachname']} ({$row['email']})<br>";
            echo "Rooms: " . $row['room_numbers'] . "<br>";
            echo "Price Per night: " . $row['room_prices'] . "<br>";
            echo "<hr>";
        }
        // calculate length of stay
        $startDate = new DateTime($row['start_date']);
        $endDate = new DateTime($row['end_date']);
        $stayDuration = $startDate->diff($endDate)->days;

        // get individual room numbers and their prices
        $room_numbers = explode(',', $row['room_numbers']);
        $room_prices = explode(',', $row['room_prices']);
        $room_charge = calculate_room_charge($room_numbers, $room_prices, $stayDuration);

        $parking = $row['parking'];
        $breakfast = $row['breakfast'];
        $pets = $row['pets'];
        $person_amount = $row['person_amount'];
        $additional_charge = calculate_additional_charges($parking, $breakfast, $pets, $person_amount, $stayDuration);

        $total_charge = $room_charge + $additional_charge;

        $update_total_charge = "UPDATE `reservations` SET `total_charge` = ? Where `reservation_id` = ?";
        $update_data = $db_obj->prepare($update_total_charge);
        $update_data->bind_param("ii", $total_charge, $row['reservation_id']);
        $update_data->execute();

        if ($debug) {
            echo $stayDuration . '<br>';
            echo $room_charge . '<br>';
            echo $additional_charge . '<br>';
            echo $total_charge . '<br>';
            echo "<hr>";
        }
    }
    $result->free();
    $update_data->close();

} else {
    echo "Fehler: " . $db_obj->error;
}

?>