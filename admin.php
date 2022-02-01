<?php
require "Engine.php";
$users = Engine::getUsers();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Trelloclone - Admin</title>
    <?php include("components/scripts.php") ?>

</head>
<body>
<?php include("components/nav.php") ?> 
<?php require("adminMiddleware.php")?>
<div class="container my-3">
    <h1>Prikaz korisnika</h1>
    <?php foreach ($users as $user): ?>
        <?php if ($user['id'] != $_SESSION['uid']): ?>
            <div class="card my-3">
                <div class="card-header">
                    <strong><?php echo($user['email']); ?></strong>
                </div>
                <div class="card-body">
                    <form action="app.php" method="POST">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="fname">Ime</label>
                                    <input class="form-control" type="text" name="fname"
                                           value="<?php echo $user['fname']; ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="lname">Prezime</label>
                                    <input class="form-control" type="text" name="lname"
                                           value="<?php echo $user['lname']; ?>">
                                </div>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="email">Email adresa</label>
                                    <input class="form-control" type="text" name="email"
                                           value="<?php echo $user['email']; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <a href="app.php?delete_user=<?php echo $user['id']; ?>"
                                   class="btn btn-block btn-danger w-50 mx-auto">Ukloni korisnika</a>
                            </div>
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-block btn-warning w-50 mx-auto">Izmeni korisnika
                                </button>
                            </div>
                        </div>
                        <input type="hidden" name="oldEmail" value="<?php echo $user['email']; ?>">
                        <input type="hidden" name="edit_user" value="1">
                    </form>
                </div>
            </div>
        <?php endif; ?>
    <?php endforeach; ?>

</div>
</body>
</html>