<div class="container mt-5">
    <div class="table-responsive">
        <?php
        if (!isset($_SESSION['show_details'])) {
            $_SESSION['show_details'] = false;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['show_details'])) {
            $_SESSION['show_details'] = !$_SESSION['show_details'];
        }

        // Use $_SESSION['show_details'] in your logic
        $show_details = $_SESSION['show_details'];
        ?>

        <h2 class="mb-4">Aktuelle Reservierungen</h2>
        <form action="admin.php" method="post">
            <button type="submit" name="show_details">Show Details</button>
        </form>
        <!-- table with current reservation data -->
        <table class="table">
            <thead>
                <tr>
                    <th>Vorname</th>
                    <th>Nachname</th>
                    <th>User Email</th>
                    <th>Reservierungsnummer</th>
                    <th>Preis</th>
                    <th>Zeitpunkt Buchung</th>
                    <?php
                    if ($show_details) {
                        echo '
                        <th>Checkin</th>
                        <th>Checkout</th>
                        <th>Frühstück</th>
                        <th>Parkplatz</th>
                        <th>Haustiere</th>
                        <th>Reservierung Status</th>
                        <th>Personen</th>
                        <th>Zimmer</th>
                    ';
                    }
                    ?>

                </tr>
            </thead>
            <tbody>
                <?php
                require_once('../../config/dbaccess.php');
                // Fetch reservation and user info for all reservations
                // groupconcat: makes multiple rooms for one reservation into one string
                // group by: distinguish between concated and non-concat
                $get_reservations_query = "
    SELECT 
        r.`reservation_id`, r.`user_id`, r.`start_date`, r.`end_date`,
        r.`breakfast`, r.`parking`, r.`pets`, r.`reservation_status`, r.`person_amount`,
        u.`vorname`, u.`nachname`, u.`email`, r.`total_charge`, r.`created_at`,
        GROUP_CONCAT(ro.`room_number` ORDER BY ro.`room_number` ASC) AS `room_numbers`
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
        u.`vorname`, u.`nachname`, u.`email`, r.`total_charge`, r.`created_at`";

                $fetch_data = $db_obj->prepare($get_reservations_query);
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
                    echo "<td>{$row['vorname']}</td>";
                    echo "<td>{$row['nachname']}</td>";
                    echo "<td>{$row['email']}</td>";
                    echo "<td>{$row['reservation_id']}</td>";
                    echo "<td>{$row['total_charge']}</td>";
                    echo "<td>" . date("Y-m-d H:i:s", strtotime($row['created_at'])) . "</td>";
                    if ($show_details) {
                        echo "<td>" . date("Y-m-d", strtotime($row['start_date'])) . "</td>";
                        echo "<td>" . date("Y-m-d", strtotime($row['end_date'])) . "</td>";
                        echo "<td>{$row['breakfast']}</td>";
                        echo "<td>{$row['parking']}</td>";
                        echo "<td>{$row['pets']}</td>";
                        echo "<td>{$row['reservation_status']}</td>";
                        echo "<td>{$row['person_amount']}</td>";
                        echo "<td>{$row['room_numbers']}</td>";
                    }
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