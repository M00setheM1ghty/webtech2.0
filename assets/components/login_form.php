<div class="container">
  <form method="post" action="login.php">
    <!-- Email input -->
    <div class="form-outline mb-4">
      <input type="text" id="email-login" class="form-control" name="email-login" />
      <label class="form-label" for="email-login">Email</label>
    </div>

    <!-- Password input -->
    <div class="form-outline mb-4">
      <input type="password" id="password" class="form-control" name="password" />
      <label class="form-label" for="password">Password</label>
    </div>
    <div class="error"><?php if(isset($loginError)){echo $loginError . '<br>';}?></div>
    <div class="error"><?php if(isset($inactive_user_msg)){echo $inactive_user_msg;}?></div>
    <!-- submit button -->
    <button type="submit" name="login" class="btn btn-primary btn-block mb-4">Login</button>

    <!-- register button -->
    <div class="text-center">
      <p>Noch kein Account? <a href="registration.php">Hier registrieren</a></p>
    </div>
  </form>
</div>