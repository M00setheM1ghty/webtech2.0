<!-- table with users -->
<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th>Vorname</th>
                <th>Nachname</th>
                <th>Email</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Fetch reservations for the current user based on email
            require_once('../../config/dbaccess.php');
            $get_users_query = "
                            SELECT `nachname`, `vorname`, `email`, `user_status`
                            FROM `user_profil`";
            $fetch_users = $db_obj->prepare($get_users_query);
            $fetch_users->execute();
            // put results in an assoc array
            $fetched_users_array = $fetch_users->get_result();

            if ($debug) {
                if ($fetch_data->error) {
                    echo "Query error: " . $fetch_data->error;
                }

            }
            // Loop through reservations and display in the table
            while ($row = $fetched_users_array->fetch_assoc()) {
                echo "<tr>";
                echo "<td>{$row['vorname']}</td>";
                echo "<td>{$row['nachname']}</td>";
                echo "<td>{$row['email']}</td>";
                echo "<td>{$row['user_status']}</td>";
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