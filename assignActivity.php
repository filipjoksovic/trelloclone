<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>TrelloClone - Assign activity</title>
    <?php include("components/scripts.php"); ?>
</head>
<body>
<?php include("components/nav.php"); ?>
<?php
require "Engine.php";
$activity_id = $_GET['id'];
$activity = Engine::getActivity($activity_id);
$users = Engine::getRegularUsers();
?>
<div class="container my-3">
    <div class="row">
        <div class="col-md-4">
            <h1 class="display-4">Projektna aktivnost</h1>
            <div>
                <p class="lead">Naziv:</p>
                <p class="lead"><?php echo $activity['name']; ?></p>
            </div>
            <div>
                <p class="lead">Opis:</p>
                <p class="lead"><?php echo $activity['description']; ?></p>
            </div>
        </div>
        <div class="col-md-8">
            <form action="app.php" method="POST">
                <div class="form-group">
                    <label for="user">Korisnik</label>
                    <select name="user_id" id = "user" class = "form-control">
                        <?php foreach ($users as $user): ?>
                            <option value="<?php echo $user['id']; ?>"><?php echo $user['fname'] . " " . $user['lname'] . " - " . $user['email'];?></option>
                        <?php endforeach ?>
                    </select>
                </div>
                <input type="hidden" name="activity_id" value = "<?php echo $activity_id;?>">
                <input type="hidden" name="assign_activity" value = "1">
                <button type = "submit" class = "btn btn-success w-50 mx-auto d-block">Dodeli aktivnost</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>