<?php session_start(); ?>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Trelloclone</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <?php if (isset($_SESSION['uid'])): ?>
                    <!--user logged in section-->
                    <?php if ($_SESSION['role_id'] == 1): ?>
                        <li class="nav-item active">
                            <a class="nav-link" href="/home.php">Pocetna</a>
                        </li>
                    <?php endif; ?>
                    <?php if ($_SESSION['role_id'] == 2): ?>
                        <li class="nav-item active">
                            <a class="nav-link" href="/manager.php">Pocetna</a>
                        </li>
                        <li class="nav-item active">
                            <a class="nav-link" href="/createProject.php">Kreiraj projekat</a>
                        </li>
                    <?php endif; ?>
                    <!--Admin section-->
                    <?php if ($_SESSION['role_id'] == 3): ?>
                        <li class="nav-item active">
                            <a class="nav-link" href="/admin.php">Pocetna</a>
                        </li>
                        <li class="nav-item active">
                            <a class="nav-link" href="/createUser.php">Dodaj korisnika</a>
                        </li>
                    <?php endif; ?>
                    <li class="nav-item active">
                        <a class="nav-link"
                           href="/app.php?logout=1"><?php echo $_SESSION['fname'] . " " . $_SESSION['lname']; ?> -
                            Odjavi se</a>
                    </li>
                <?php else: ?>
                    <!--login section-->
                    <li class="nav-item active">
                        <a class="nav-link" href="/login.php">Login</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="/home.php">Registracija</span></a>
                    </li>
                <?php endif ?>
            </ul>

        </div>
    </nav>
<?php require("messages.php") ?>