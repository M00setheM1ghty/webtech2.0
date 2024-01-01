<?php
session_start();

$debug = true;
// include functions
require_once ('../components/functions.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['login'])) {
        // Login logic
        $email_input = test_input($_POST['email-login']);
        $password_input = $_POST['password'];

        if ($debug) {
            echo $email_input . '<br>';
            echo $password_input . "<br>";
        }

        // get email and pswd from db to compare with input
        require_once('../../config/dbaccess.php');
        $get_vars = "SELECT email, pswd, vorname FROM user_profil WHERE email=?";
        $stmt = $db_obj->prepare($get_vars);
        $stmt->bind_param("s", $email_input);
        $stmt->execute();
        $stmt->bind_result($user_mail, $user_pswd_hashed, $user_name);
        $stmt->fetch();
        $stmt->close();

        if ($debug) {
            echo "Email: " . $user_mail . "<br>";
            echo "Hashed Password: " . $user_pswd_hashed . "<br>";
            echo "Username: " . $user_name . "<br>";
        }

        // compare passwords
        $pswd_match = password_verify($password_input, $user_pswd_hashed);
        if ($debug) {
          echo "Password Match: " . ($pswd_match ? 'Yes' : 'No') . "<br>";
      }
        
        if ($pswd_match) {
            $_SESSION['username'] = $user_name;
            $_SESSION['email'] = $user_mail;
            $_SESSION['pswd'] = $user_pswd_hashed;

            $pswd_success = 'Passwort ist gültig.'; 
            header('Location: profile.php');
            exit();
        } else {
            $loginError = 'Falscher username oder passwort';
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>
<style>
    .error {
        color: #FF0000;
    }
</style>

<head>
    <?php include(dirname(__DIR__) . '/components/head.php'); ?>
</head>

<body>
    <?php include(dirname(__DIR__) . '/components/nav.php'); ?>
    <main>
        <div class="container">
            <div class="p-5 mb-4 bg-body-tertiary rounded-3">
                <div class="container-fluid py-5">
                    <h1 class="display-5 fw-bold">Hotel Hämmerle</h1>
                    <p class="col-md-8 fs-4">Hier zum Login für die Website:</p>
                </div>
            </div>
        </div>
        <?php include(dirname(__DIR__) . '/components/login_form.php'); ?>
        <?php include(dirname(__DIR__) . '/components/footer.php'); ?>
    </main>
</body>

</html>