<?php
$debug = false;
require_once('../components/functions.php');
// process data and add to db
require_once('../../config/dbaccess.php');

// ...........master data change logic..................//

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['change_masterdata'])) {
    // required fields array
    $requiredFields = ['fname-new', 'lname-new', 'email-old', 'email-new', 'password-new', 'password-new-check'];
    $fieldsEmpty = false;

    // Check if any required field is empty
    foreach ($requiredFields as $field) {
        if (empty($_POST[$field])) {
            $fieldsEmpty = true;
            break; // Exit the loop if any field is empty
        }
    }
    if ($_SESSION['password-new'] !== $_SESSION['password-new-check']) {
        $pswd_check_error = 'Passwörter stimmen nicht überein.';
    } elseif ($fieldsEmpty) {
        $empty_field_error = 'Alle Formfelder müssen ausgefüllt sein';
    } else {
        // Retrieve form data
        $fnameNew = test_input($_POST['fname-new']);
        $lnameNew = test_input($_POST['lname-new']);
        $oldEmail = test_input($_POST['email-old']);
        $newEmail = test_input($_POST['email-new']);
        $passwordNew = $_POST['password-new'];
        $password_new_hashed = password_hash($passwordNew, PASSWORD_ARGON2I);

        // Update the user profile 
        $updateQuery = "UPDATE user_profil SET vorname = ?, nachname = ?, email = ?, pswd = ? WHERE email = ?";

        $update_masterdata = $db_obj->prepare($updateQuery);

        if ($update_masterdata) {
            $update_masterdata->bind_param("sssss", $fnameNew, $lnameNew, $newEmail, $password_new_hashed, $oldEmail);
            $update_masterdata->execute();

            // throw errors or success msg
            if ($update_masterdata->affected_rows > 0) {
                $update_success = "Profil wurde aktualisiert";
            } else {
                $update_fail = "Aktualisierung nicht erfolgreich. Alte Email Adresse möglicherweise inkorrekt";
            }

            // Close the statement
            $update_masterdata->close();
        } else {
            if ($debug)
                echo "sql statement fehler";
        }
    }
}

// .................................user status change logic............................................//

if (isset($_POST['change_status'])) {
    if (isset($_POST['user-status']) && isset($_POST['uemail'])) {
        $selected_status = $_POST['user-status'];
        $uemail = $_POST['uemail'];
        // Update the user status
        $updateQueryStatus = "UPDATE user_profil SET user_status = ? WHERE email = ?";
        $update_status = $db_obj->prepare($updateQueryStatus);

        if ($update_status) {
            $update_status->bind_param("ss", $selected_status, $uemail);
            $update_status->execute();

            if ($update_status->affected_rows > 0) {
                $status_update_success = "User Status wurde aktualisiert";
            } else {
                $status_update_fail = "Keine Aktulisierung vorgenommen. User Email existiert nicht.";
            }
            $update_status->close();
        } else {
            if ($debug)
                echo "sql statement fehler";
        }
    }
}
// .................................reservation status change logic............................................//

if (isset($_POST['change_status_reservation'])) {
    if (isset($_POST['reservation-id'])) {
        $selected_status = $_POST['reservation-status'];
        $reservation_id = $_POST['reservation-id'];
        // Update the user status
        $updateQueryStatus = "UPDATE `reservations` SET `reservation_status` = ? WHERE `reservation_id` = ?";
        $update_status = $db_obj->prepare($updateQueryStatus);

        if ($update_status) {
            $update_status->bind_param("ss", $selected_status, $reservation_id);
            $update_status->execute();

            if ($update_status->affected_rows > 0) {
                $status_update_success_reservation = "Reservierungstatus wurde aktualisiert";
            } else {
                $status_update_fail_reservation = "Keine Aktulisierung vorgenommen. Reservierungs-ID existiert nicht.";
            }
            $update_status->close();
        } else {
            if ($debug)
                echo "sql statement fehler";
        }
    }
}
?>

<div class="container">
    <h1>Userverwaltung</h1>
    <div class="container mt-5">
        <h2 class="mb-4">Userliste</h2>
        <?php include(dirname(__DIR__) . '/components/display_userlist.php'); ?>
        <!-- change master data -->
        <div class="container">
            <form method="post" action="admin.php">
                <h1 class="mb-4">User Stammdaten ändern</h1>
                <!-- name input -->
                <div class="form-outline mb-4">
                    <input type="text" id="fname-new" class="form-control" name="fname-new" required />
                    <label class="form-label" for="fname-new">Vorname</label>
                    <input type="text" id="lname-new" class="form-control" name="lname-new" required />
                    <label class="form-label" for="lname-new">Nachname</label>
                </div>
                <!-- Email input -->
                <div class="form-outline mb-4">
                    <input type="text" id="email-old" class="form-control" name="email-old" required />
                    <label class="form-label" for="email-old">alte Email-Adresse</label>
                    <input type="text" id="email-new" class="form-control" name="email-new" required />
                    <label class="form-label" for="email-new">neue Email-Adresse</label>
                </div>
                <!-- Password input -->
                <div class="form-outline mb-4">
                    <input type="password" id="password-new" class="form-control" name="password-new" required />
                    <label class="form-label" for="password-new">neues Passwort</label>
                    <input type="password" id="password-new-check" class="form-control" name="password-new-check"
                        required />
                    <label class="form-label" for="password-new-check">Passwort-Check</label>
                </div>
                <!-- display error msgs -->
                <div class="error">
                    <?php if (isset($pswd_check_error)) {
                        echo $pswd_check_error . '<br>';
                    }
                    if (isset($update_success)) {
                        echo $update_success . '<br>';
                    }
                    if (isset($update_fail)) {
                        echo $update_fail . '<br>';
                    }
                    if (isset($empty_field_error)) {
                        echo $empty_field_error . '<br>';
                    } ?>
                </div>
                <!-- submit button change masterdata -->
                <button type="submit" name="change_masterdata" class="btn btn-primary btn-block mb-4">OK</button>
            </form>

            <!-- change user status form  -->
            <form action="admin.php" method="post">
                <h2> User Status ändern</h2>
                <!-- Email input -->
                <div class="form-outline mb-4">
                    <input type="text" id="uemail" class="form-control" name="uemail" required />
                    <label class="form-label" for="uemail">User Email-Adresse</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" id="user-status" name="user-status" value="active"
                        checked>
                    <label class="form-check-label" for="user-status">Active</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" id="user-status-inactive" name="user-status"
                        value="inactive">
                    <label class="form-check-label" for="user-status-inactive">Inactive</label>
                </div>
                <!-- submit button change status-->
                <button type="submit" name="change_status" class="btn btn-primary btn-block mb-4">OK</button>
                <div class="error">
                    <?php
                    if (isset($status_update_success)) {
                        echo $status_update_success . '<br>';
                    }
                    if (isset($status_update_fail)) {
                        echo $status_update_fail . '<br>';
                    }
                    ?>
                </div>
            </form>
            <!-- change reservation status form  -->
            <form action="admin.php" method="post">
                <h2> Reservierung's Status ändern</h2>
                <!-- Email input -->
                <div class="form-outline mb-4">
                    <input type="text" id="reservation-id" class="form-control" name="reservation-id" required />
                    <label class="form-label" for="reservation-id">Reservierung's ID</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" id="bestaetigt" name="reservation-status"
                        value="bestaetigt" checked>
                    <label class="form-check-label" for="user-status">Bestaetigt</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" id="storniert" name="reservation-status"
                        value="storniert">
                    <label class="form-check-label" for="storniert">Storniert</label>
                </div>
                <!-- submit button change status-->
                <button type="submit" name="change_status_reservation"
                    class="btn btn-primary btn-block mb-4">OK</button>
                <div class="error">
                    <?php
                    if (isset($status_update_success_reservation)) {
                        echo $status_update_success_reservation . '<br>';
                    }
                    if (isset($status_update_fail_reservation)) {
                        echo $status_update_fail_reservation . '<br>';
                    }
                    ?>
                </div>
            </form>
        </div>
    </div>