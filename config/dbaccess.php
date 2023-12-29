<?php
$servername = "localhost";
$username = "thomas";
$password = "Tommy97xampp#";
$database = "db_hotel";

$db_obj = new mysqli($servername, $username, $password, $database);

        if ($db_obj->connect_error) {
            echo "Connection Error: " . $db_obj->connect_error;
            exit();
        }
?>

