<?php

?>

<form action="insert_into_db.php" method="post">
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

  <button type="reset" class="btn btn-primary btn-block mb-4">Reset</button>
  <button type="submit" name="reg_submit" value="Register" class="btn btn-primary btn-block mb-4">Submit</button>
</form>

<?php

?>