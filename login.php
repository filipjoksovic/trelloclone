<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Trelloclone - Login</title>
    <?php include("components/scripts.php") ?>
</head>
<body>
<?php include("components/nav.php") ?>

<div class="container my-3">
    <h1>Login</h1>
    <form action = "app.php" method = "POST">
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" name = "email" id="email" aria-describedby="email">
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" name = "password" id="password">
        </div>
        <p class = "text-center">Nemate nalog? Registrujte se <a href = "register.php">ovde</a></p>
        <input type = "hidden" name = "login" value = "1">
        <button type="submit" class="btn btn-primary">Login</button>
    </form>

</div>
</body>
</html>