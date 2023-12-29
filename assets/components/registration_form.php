<?php
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
  /*
  if (isset($_POST["gender"])) {
    $selectedGender = test_input($_POST["gender"]);
  }*/

  if (empty($_POST["password"]) || empty($_POST["password-check"])) {
    $passwordErr = "Passwort fehlt";
    increment_error_var($error_var);
  } else {
    $password = $_POST["password"];
  }
  if (($_POST["password"] != $_POST["password-check"])) {
    $passwordcheckErr = "Passwörter stimmen nicht überein";
    increment_error_var($error_var);
  } else {
    $passwordcheck = $_POST["password-check"];
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

  if ($error_var > 0) {
    $error_var = 0;
    return;
    if ($user_count > 0) {
      echo 'User mit dieser Email existiert bereits.';
    } else {
      // Insert user profile data and hash pswd
      if (true)
        $password_hashed = password_hash($password, PASSWORD_ARGON2I);
      $insert_user_profil_data =
        "INSERT INTO `user_profil` (`vorname`, `nachname`, `email`, `rollen_id`, `password`)
     VALUES (?,?,?,?,?)";
      $stmt = $db_obj->prepare($insert_user_profil_data);
      $stmt->bind_param("sssii", $vorname, $nachname, $mail, $rollen_id, $password_hashed);
      $stmt->execute();
      $stmt->close();
    }
  }

}



//insert user information into db with prepared statements

?>

<form action="registration.php" method="post">
  <div>
    <label for="anrede" class="form-label">Anrede</label>
    <input type="text" name="anrede" id="anrede" class="form-control" required>
  </div>
  <div>
    <label for="fname" class="form-label">Name</label>
    <input type="text" name="fname" id="fname" class="form-control" required>
  </div>
  <div>
    <label for="lname" class="form-label">Nachname</label>
    <input type="text" name="lname" id="lname" class="form-control" required>
  </div>
  <div>
    <label for="email" class="form-label">Email</label>
    <input type="email" name="email" id="email" class="form-control" required>
  </div>

  <div>
    <label for="telefon" class="form-label">Telefon</label>
    <input type="tel" name="telefon" id="telefon" class="form-control" required>
  </div>

  <div>
    <label for="date" class="form-label">Geburtstag</label>
    <input type="date" name="date" id="date" min="2007-22-09" class="form-control">
  </div>
  <div>
    <label for="password" class="form-label">Passwort</label>
    <input type="password" name="password" id="password" class="form-control" required>
    <label for="password-check" class="form-label">Passwort-Check</label>
    <input type="password" name="password-check" id="password-check" class="form-control" required>
  </div>

  <div>
    <label for="nutrition" class="form-label">bevorzugte Ernährung:</label>
    <select id="nutrition" name="nutrition" title="ernährung" class="form-select">
      <option value="allesesser">keine Präferenz</option>
      <option value="Vegetarier">Vegetarisch</option>
      <option value="Vegan">Vegan</option>
      <option value="pescetarier">Pescetarisch</option>
    </select>
  </div>
  <br>
  <div class="form-control">
    <label for="andere">Unverträglichkeiten</label>
    <input title="andere" for="andere" type="text" class="form-control" />
  </div>

  <label for="gender" class="form-label">Geschlecht:</label>
  <div id="gender">
    <div>
      <label for="male" class="form-label">Male</label>
      <input type="radio" name="gender" id="male" value="male">
    </div>
    <div>
      <label for="female" class="form-label">Female</label>
      <input type="radio" name="gender" id="female" value="female">
    </div>
    <div>
      <label for="diverse" class="form-label">Divers</label>
      <input type="radio" name="gender" id="diverse" value="diverse">
    </div>
  </div>

  <button type="reset">Reset</button>
  <button type="submit">Submit</button>
</form>

<?php
function test_input($data)
{
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

function increment_error_var($error_var)
{
  $error_var += 1;
}
?>