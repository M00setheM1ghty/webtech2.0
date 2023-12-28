<?php
// define variables and set to empty values
$anredeErr = $fnameErr = $lnameErr = $usernameErr = $emailErr = $telefonErr = $passwordErr = $passwordcheckErr = "";
$anrede = $fname = $lname = $username = $email = $telefon = $password = $passwordcheck = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST["anrede"])) {
    $anredeErr = "Anrede fehlt";
  } else {
    $name = test_input($_POST["anrede"]);
  }

  if (empty($_POST["email"])) {
    $emailErr = "Email fehlt";
  } else {
    $email = test_input($_POST["email"]);
  }

  if (empty($_POST["fname"])) {
    $fnameErr = "Vorname fehlt";
  } else {
    $fname = test_input($_POST["fname"]);
  }

  if (empty($_POST["lname"])) {
    $lnameErr = "Nachname fehlt";
  } else {
    $lname = test_input($_POST["lname"]);
  }

  if (empty($_POST["username"])) {
    $usernameErr = "Username fehlt";
  } else {
    $username = test_input($_POST["username"]);
  }

  if (empty($_POST["telefon"])) {
    $telefonErr = "Telefonnummer fehlt";
  } else {
    $telefon = test_input($_POST["telefon"]);
  }

  if (empty($_POST["password"]) || empty($_POST["password-check"])) {
    $passwordErr = "Passwort fehlt";
  }
  if (($_POST["password"] != $_POST["password-check"])){
    $passwordcheckErr = "Passwörter stimmen nicht überein";
  }
}
?>

<form action="registration.php" method="post">
  <div>
    <label for="anrede" class="form-label">Anrede</label>
    <input type="text" name="name" id="anrede" class="form-control" required>
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
    <label for="Telefon" class="form-label">Telefon</label>
    <input type="tel" name="Telefon" id="Telefon" class="form-control" required>
  </div>

  <div>
    <label for="date" class="form-label">Geburtstag</label>
    <input type="date" name="date" id="date" min="2007-22-09" class="form-control">
  </div>
  <div>
    <label for="password" class="form-label">Passwort</label>
      <input type="password" name="password" id="passwort" class="form-control" required>
    <label for="password-check" class="form-label">Passwort-Check</label>
      <input type="password" name="password-check" id="password-check" class="form-control" required>
  </div>

  <div>
    <label for="nutrition" class="form-label">bevorzugte Ernährung:</label>
    <select id="nutrition" title="ernährung" class="form-select">
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
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>