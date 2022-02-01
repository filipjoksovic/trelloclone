<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>TrelloClone - Assign project</title>
    <?php include("components/scripts.php"); ?>
</head>

<body>
    <?php include("components/nav.php"); ?>
    <?php require("managerMiddleware.php");?>
    <?php
    require "Engine.php";
    $project_id = $_GET['id'];
    $activities = Engine::getProjectActivities($project_id);
    $project = Engine::getProject($project_id);
    $users = Engine::getRegularUsers();
    ?>
    <div class="container my-3">
        <div class="row">
            <div class="col-md-4">
            <h1 class="display-4">Detalji </h1>
                <div class="container-fluid">
                    <p class="lead font-weight-bold">Naziv projekta:</p>
                    <p class="lead"><?php echo $project['name']; ?></p>
                    <p class="lead font-weight-bold">Lokacija:</p>
                    <p class="lead"><?php echo $project['location']; ?></p>
                    <p class="lead font-weight-bold">Strucna spreme:</p>
                    <p class="lead"><?php echo $project['education_level']; ?></p>
                    <p class="lead font-weight-bold">Opis:</p>

                    <p class="lead"><?php echo $project['description']; ?></p>
                    <p class="lead font-weight-bold">Pogodnosti za zaposlene:</p>

                    <p class="lead"><?php echo $project['benefits']; ?></p>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card">
                    <ul class="list-group list-group-flush">
                        <?php foreach ($activities as $activity) : ?>
                            <li class="list-group-item">
                                <div class="container-fluid">
                                    <div class="my-2 row align-items-center justify-content-between">
                                        <div class="col-md-4 text-left">
                                            <?php echo $activity['name']; ?>
                                        </div>
                                        <div class="col-md-8 text-right">
                                            <?php echo $activity['description']; ?>
                                        </div>
                                    </div>
                                </div>
                            </li>

                        <?php endforeach ?>
                    </ul>
                </div>
                <form action="app.php" method="POST" class = "my-3">
                    <div class="form-group">
                        <label for="user">Korisnik</label>
                        <select name="user_id" id="user" class="form-control">
                            <?php foreach ($users as $user) : ?>
                                <option value="<?php echo $user['id']; ?>"><?php echo $user['fname'] . " " . $user['lname'] . " - " . $user['email']; ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <input type="hidden" name="project_id" value="<?php echo $project_id; ?>">
                    <input type="hidden" name="assign_project" value="1">
                    <button type="submit" class="btn btn-success w-50 mx-auto d-block">Dodeli aktivnost</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>