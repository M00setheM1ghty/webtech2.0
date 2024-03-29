<?php
include(dirname(__DIR__) . '/components/hide_warnings.php');
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
// retrieve rollen_id to display admin.php if necessary
$email = $_SESSION['email'];
require_once('../../config/dbaccess.php');
if (isset($email)) {
    $selectRollenIdQuery = "SELECT `rollen_id` FROM `user_profil` WHERE `email` = ?";
    $stmtSelectRollenId = $db_obj->prepare($selectRollenIdQuery);
    $stmtSelectRollenId->bind_param("s", $email);
    $stmtSelectRollenId->execute();
    $stmtSelectRollenId->bind_result($rollen_id);
    $stmtSelectRollenId->fetch();
    $stmtSelectRollenId->close();
}
$_SESSION['rollen_id'] = $rollen_id;
?>
<nav class="navbar navbar-expand-md navbar-light bg-white">
    <!-- burger menu for screen size under medium size -->
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item active">
                    <a href="index.php" class="nav-link">Startseite</a>
                </li>
                <li class="nav-item">
                    <a href="impressum.php" class="nav-link">Impressum</a>
                </li>
                <li class="nav-item">
                    <a href="faq.php" class="nav-link">FAQ</a>
                </li>
                <li class="nav-item">
                    <a href="news.php" class="nav-link">News</a>
                </li>
                <!-- display reservation if username is set -->
                <?php
                if (isset($_SESSION['username'])) {
                    echo '<li class="nav-item">
                <a href="reservierung.php" class="nav-link">Reservierung</a>
            </li>';
                }
                ?>
                <?php
                if (isset($_SESSION['rollen_id']) && $rollen_id === 1) {
                    echo '<li class="nav-item">
                <a href="admin.php" class="nav-link">Admin</a>
            </li>';
                }
                ?>
                <!-- display registration if username not set -->
                <?php
                if (!isset($_SESSION['username'])) {
                    echo '<li class="nav-item">
                <a href="registration.php" class="nav-link">Registrierung</a>
            </li>';
                }
                ?>

                <!-- change to login/logout depending on user -->
                <?php
                if (!isset($_SESSION['username'])) {
                    echo '<li class="nav-item">
                <a href="login.php" class="nav-link">Login</a>
            </li>';
                }
                ?>

                <!-- if User is logged in, show the navbar element and the name -->
                <?php
                if (isset($_SESSION['username'])) {
                    echo '<li class="nav-item">
              <a href="profile.php" class="nav-link">Profil</a>
          </li>';

                    echo '<li class="nav-item">
              <a href="#" class="nav-link">Angemeldet: ';

                    if (isset($_SESSION["username"])) {
                        echo $_SESSION["username"];
                    }

                    echo '</a>
          </li>';
                }
                ?>
                <?php
                if (isset($_SESSION['username'])) {
                    echo '<form method="post" action="' . $_SERVER['PHP_SELF'] . '">
                <button class="btn btn-dark float-end" type="submit" name="logout">Logout</button>
            </form>';
                }
                ?>
            </ul>
        </div>
    </div>
</nav>