<?php
$users = [
    'thomas' => ['password' => 'thomas1', 'email' => 'thomas@example.com', 'name' => 'thomas'],
    'markus' => ['password' => 'markus1', 'email' => 'markus@example.com', 'name' => 'markus'],
];

session_start();
// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}

// Retrieve user data based on the logged-in username
$loggedInUser = $users[$_SESSION['username']];

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
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['change-password'])) {
    // Validate the current password
    $currentPassword = $_POST['current-password'];
    $newPassword = $_POST['new-password'];
    $newPasswordCheck = $_POST['new-password-check'];

    $loggedInUsername = $_SESSION['username'];

    // Password spell check
    if ($newPassword !== $newPasswordCheck) {
        $passwordChangeError = 'Passwörter stimmen nicht überein';
    } elseif (isset($users[$loggedInUsername]) && $users[$loggedInUsername]['password'] === $currentPassword) {
        // Update the password
        $users[$loggedInUsername]['password'] = $newPassword;
        // Display a success message or redirect to a different page
        $passwordChangeSuccess = true;
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
                    <?php echo $loggedInUser['name']; ?>!
                </p>
            </div>
        </div>


        <div class="row">
            <div class="col-auto">
                Email:
                <?php echo $loggedInUser['email']; ?>
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
                <h3>Willst du die Erinnerungen teilen?</h3>
                <p>Lade doch gerne Fotos von deinem Besuch hoch! Deine Bilder machen nicht nur deine Erfahrung
                    unvergesslich,
                    sondern helfen auch zukünftigen Besuchern, die Vorfreude zu teilen. Wir würden uns freuen, deine
                    Eindrücke zu sehen! #TeileDeinErlebnis</p>
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
            </div>
        </form>
        <?php
        // Display success message or error message
        if (isset($passwordChangeSuccess)) {
            echo '<p>Password wurde geändert!</p>';
        } elseif (isset($passwordChangeError)) {
            echo '<p>Error: ' . $passwordChangeError . '</p>';
        }
        ?>
    </div>
    </div>


    </div>
    <?php include(dirname(__DIR__) . '/components/footer.php'); ?>
</body>

</html>