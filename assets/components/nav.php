<nav class="navbar navbar-expand">
    <div class="container">
        <a href="#" class="navbar-brand">HS</a>
        <ul class="navbar-nav">
            <li class="nav-item">
                <a href="index.php" class="nav-link">Startseite</a>
            </li>
            <li class="nav-item">
                <a href="impressum.php" class="nav-link">Impressum</a>
            </li>
            <li class="nav-item">
                <a href="faq.php" class="nav-link">FAQ</a>
            </li>
            <li class="nav-item">
                <a href="registration.php" class="nav-link">Registrierung</a>
            </li>

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
                <button type="submit" name="logout">Logout</button>
            </form>';
            }
            ?>
        </ul>
    </div>
</nav>