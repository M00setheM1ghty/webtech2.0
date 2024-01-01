<?php
//variable declarations
$passwordChangeError = "";

session_start();
// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}

// Retrieve user data based on the logged-in username
//$loggedInUser = $users[$_SESSION['username']];

// Handle logout if the logout button is clicked
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['logout'])) {
    // Unset all session variables
    $_SESSION = array();

    // Destroy the session
    session_destroy();

    // Redirect to the login page after logout
    header('Location: login.php');
    exit;
}

// change password logic
require_once('../../config/dbaccess.php');
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['change-password'])) {

    // Password check
    $currentPassword = $_POST['current-password'];
    $newPassword = $_POST['new-password'];
    $newPasswordCheck = $_POST['new-password-check'];
    $user_pswd_hashed = $_SESSION['pswd'];
    $current_email = $_SESSION['email'];

    $loggedInUsername = $_SESSION['username'];

    // Validate the current password
    if (password_verify($currentPassword, $user_pswd_hashed)) {
        $passwordChangeError = "";
        if ($newPassword === $newPasswordCheck) {
            $passwordChangeSuccess = "Passwort wurde geändert";
            //update pswd in db
            $password = $newPassword;
            $password_hashed = password_hash($newPassword, PASSWORD_ARGON2I);
            $update_pswd =
                "UPDATE `user_profil` SET `pswd` = ? WHERE `email` = ?";
            $insert_pswd = $db_obj->prepare($update_pswd);
            $insert_pswd->bind_param("ss", $password_hashed, $current_email);

            if ($insert_pswd->execute()) {
                echo $passwordChangeSuccess;
            } else {
                echo "Execution failed.";
            }
            $insert_pswd->close();
            $db_obj->close();
        }
    } else {
        $passwordChangeError = 'Falsches Passwort!';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>User Profile</title>
    <?php include(dirname(__DIR__) . '../components/head.php'); ?>
</head>
</head>

<body>
    <?php include(dirname(__DIR__) . '/components/nav.php'); ?>
    <div class="container">
        <div class="p-5 mb-4 bg-body-tertiary rounded-3">
            <div class="container-fluid py-5">
                <h1 class="display-5 fw-bold">Willkommen</h1>
                <p class="col-md-8 fs-4">
                    <?php if (isset($_SESSION['username'])) {
                        echo $_SESSION['username'];
                    } ?>!
                </p>
            </div>
        </div>


        <div class="row">
            <div class="col-auto">
                Email:
                <?php if (isset($_SESSION['email'])) {
                    echo $_SESSION['email'];
                } ?>
            </div>
            <div class="col-auto">
                <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <button type="submit" name="logout">Logout</button>
                </form>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-12">
                <h3>Wollen Sie Erinnerungen teilen?</h3>
                <p>Laden Sie Fotos von Ihrem Besuch hoch! Ihre Bilder machen nicht nur deine Erfahrung
                    unvergesslich,
                    sondern helfen auch zukünftigen Besuchern, die Vorfreude zu teilen. Wir würden uns freuen, Ihre
                    Eindrücke zu sehen! #ErlebnisTeilen</p>
            </div>
        </div>
        <form method="post" enctype="multipart/form-data" action="../components/process-form.php">
            <div class="d-flex justify-content-center">
                <!-- <input type="hidden" name="MAX_FILE_SIZE" value="1048576"> -->
                <label for="image">Image file</label>
                <input type="file" id="image" name="image">

                <button>Upload</button>

            </div>
        </form>
        <?php
        if (isset($_COOKIE["uploadStatus"])) {
            echo "Upload Sucessfull!";
        }
        ?>
        <hr>
        <div class="row">
            <div class="col-md-12">
                <h4>Willst du dein Passwort ändern?</h4>
            </div>
        </div>
        <!-- change password form-->
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <div class="row">
                <div class="col-auto">
                    <label for="current-password">Password:</label>
                    <input type="password" name="current-password" required>
                </div>
                <div class="col-auto">
                    <label for="new-password">Neues Passwort:</label>
                    <input type="password" name="new-password" required>
                </div>
                <div class="col-auto">
                    <label for="new-password-check">Neues Passwort bestätigen:</label>
                    <input type="password" name="new-password-check" required>
                </div>
                <div class="col-auto">
                    <button type="submit" name="change-password">Passwort ändern</button>
                </div>
                <?php echo $passwordChangeError
                    ?>
            </div>
        </form>
        <?php
        // Display success message or error message
        if (isset($passwordChangeSuccess)) {
            echo '<p>Password wurde geändert!</p>';
        }
        ?>
    </div>
    </div>


    </div>
    <?php include(dirname(__DIR__) . '/components/footer.php'); ?>
</body>

</html>