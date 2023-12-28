<?php
session_start();

$users = [
    'thomas' => ['password' => 'thomas1', 'email' => 'thomas@example.com', 'name' => 'thomas'],
    'markus' => ['password' => 'markus1', 'email' => 'markus@example.com', 'name' => 'markus'],
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['login'])) {
        // Login logic
        $username = $_POST['username'];
        $password = $_POST['password'];

        if (isset($users[$username]) && $users[$username]['password'] === $password) {
            $_SESSION['username'] = $username;
            header('Location: profile.php');
            exit;
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