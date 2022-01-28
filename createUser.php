<?php
require "Engine.php";
$roles = Engine::getRoles();
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Trelloclone - Create User</title>
    <?php include("components/scripts.php") ?>
</head>
<body>
<?php include("components/nav.php") ?>

<div class="container my-3">
    <h1>Dodaj korisnika</h1>
    <form action="app.php" method="POST">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="fname">Ime</label>
                    <input type="text" class="form-control" name="fname" id="fname" aria-describedby="email">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="lname">Prezime</label>
                    <input type="text" class="form-control" name="lname" id="lname">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" name="email" id="email" aria-describedby="email">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" name="password" id="password">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <label for="role">Uloga</label>
                <select name="role_id" class="form-control">
                    <?php foreach ($roles as $option): ?>
                        <?php if ($option['id'] != 3): ?>
                            <option value="<?php echo $option['id'] ?>"><?php echo $option['name']; ?></option>
                        <?php endif ?>
                    <?php endforeach ?>
                </select>
            </div>
        </div>
        <input type="hidden" name="createUser" value = "1">
        <button type="submit" class="btn btn-primary mt-3">Dodaj korisnika</button>
    </form>

</div>
</body>
</html>