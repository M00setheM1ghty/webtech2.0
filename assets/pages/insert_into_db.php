<?php
$debug = false;
// include functions
require_once('../components/functions.php');
// define variables and set to empty values
$anredeErr = $fnameErr = $lnameErr = $usernameErr = $emailErr = $telefonErr = $passwordErr = $passwordcheckErr = "";
$anrede = $fname = $lname = $username = $email = $telefon = $password = $passwordcheck = "";
$error_var = 0;

// check user input
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST["anrede"])) {
    $anredeErr = "Anrede fehlt";
    increment_error_var($error_var);
  } else {
    $anrede = test_input($_POST["anrede"]);
  }

  if (empty($_POST["email"])) {
    $emailErr = "Email fehlt";
    increment_error_var($error_var);
  } else {
    $email = test_input($_POST["email"]);
  }

  if (empty($_POST["fname"])) {
    $fnameErr = "Vorname fehlt";
    increment_error_var($error_var);
  } else {
    $fname = test_input($_POST["fname"]);
  }

  if (empty($_POST["lname"])) {
    $lnameErr = "Nachname fehlt";
    increment_error_var($error_var);
  } else {
    $lname = test_input($_POST["lname"]);
  }

  if (empty($_POST["username"])) {
    $usernameErr = "Username fehlt";
    increment_error_var($error_var);
  } else {
    $username = test_input($_POST["username"]);
  }

  if (empty($_POST["telefon"])) {
    $telefonErr = "Telefonnummer fehlt";
    increment_error_var($error_var);
  } else {
    $telefon = test_input($_POST["telefon"]);
  }

  /*if (isset($_POST["gender"])) {
    $selectedGender = test_input($_POST["gender"]);
  }*/

  if (empty($_POST["password"]) || empty($_POST["password-check"])) {
    $passwordErr = "Passwort fehlt";
    increment_error_var($error_var);
  } 
  if (($_POST["password"] != $_POST["password-check"])) {
    $passwordcheckErr = "Passwörter stimmen nicht überein";
    increment_error_var($error_var);
  } else {
    $passwordcheck = $_POST["password-check"];
  }

  if ($debug) {
    echo "Anrede: $anrede<br>";
    echo "First Name: $fname<br>";
    echo "Last Name: $lname<br>";
    echo "Email: $email<br>";
    echo "Telefon: $telefon<br>";
    echo "Password: $password<br>";
    echo "Password Check: $passwordcheck<br>";
    //exit;
  }

  // initialise variables for prepared statemtns
  $vorname = $fname;
  $nachname = $lname;
  $mail = $email;
  $rollen_id = 2; // registered user id = 2
  $user_id = null;
  $user_count = 0;

  require_once('../../config/dbaccess.php');

  // Check if user exists already
  $check_query = "SELECT COUNT(*) FROM user_profil WHERE email = ?";
  $check_stmt = $db_obj->prepare($check_query);
  $check_stmt->bind_param("s", $email);
  $check_stmt->execute();
  $check_stmt->bind_result($user_count);
  $check_stmt->fetch();
  $check_stmt->close();

  if ($debug) {
    echo $user_count . "<br>";
    echo $error_var;
  }
}

//exit if input tests threw errors
if ($error_var != 0) {
  $error_var = 0;
  header('Location: registration.php');
  exit();
}

// exit if user with email already exists
if ($user_count > 0) {
  $reg_error = "User existiert bereits";
  header('Location: registration.php');
  exit();
}
//insert user information into db with prepared statements
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Insert user profile data and hash pswd
  $password = $_POST["password"];
  $password_hashed = password_hash($password, PASSWORD_ARGON2I);
  $insert_user_profil_data =
    "INSERT INTO `user_profil` (`vorname`, `nachname`, `email`, `rollen_id`, `pswd`)
     VALUES (?,?,?,?,?)";
  $insert_stmt = $db_obj->prepare($insert_user_profil_data);
  $insert_stmt->bind_param("sssis", $vorname, $nachname, $mail, $rollen_id, $password_hashed);

  if ($insert_stmt->execute()) {
    echo 'User erstellt.';
  } else {
    echo "Fehler";
  }
  $insert_stmt->close();
  $db_obj->close();

  $_POST["username"] = $vorname;
  header('Location: login.php');
  exit();
}

?>