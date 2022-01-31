<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Trelloclone - Detalji o projektu</title>
    <?php include("components/scripts.php") ?>
</head>

<body>
<?php include("components/nav.php") ?>
<?php
require "Engine.php";
$project_id = $_GET['id'];
$project = Engine::getProject($project_id);
if ($project == null) {
    $_SESSION['error'] = "Projekat sa datom sifrom ne postoji u bazi podataka";
    header("location:manager.php");
    return;
}
$activities = Engine::getActivities($project_id);
?>
<?php if (Engine::checkForAllowedApplication($_SESSION['uid'], $project_id)): ?>
    <!--Postoje dodeljene aktivnosti-->
    <div class="container my-3">
        <div class="row text-center">
            <div class="col-md-4">
                <h1 class="display-4">Detalji</h1>
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
                <?php
                $activities = Engine::getAssignedActivities($_SESSION['uid'], $project_id);
                ?>
                <h1 class="display-4">Aktivnosti</h1>
                <?php if (empty($activities)): ?>
                    <h1 class="lead">Za ovaj projekat ne postoje unete aktivnosti. </h1>
                    <?php
                    $activity = Engine::getAssignedActivity($_SESSION['uid'], $project_id)[0];
                    ?>
                    <?php if ($activity['status_id'] != 3): ?>
                        <form action="app.php" method="POST">
                            <input type="hidden" name="advance_assignment" value="1">
                            <input type="hidden" name="assignment_id"
                                   value="<?php echo $activity['id']; ?>">
                            <button type="submit"
                                    class="btn btn-primary btn-block"><?php echo Engine::getStatusName($activity['status_id']); ?>
                                <br>-><?php echo Engine::getStatusName($activity['status_id'] + 1); ?>
                            </button>
                        </form>
                    <?php else: ?>
                        <button disabled
                                class="btn btn-success btn-block"><?php echo Engine::getStatusName($activity['status_id']); ?></button>

                    <?php endif; ?>
                <?php else: ?>
                    <?php foreach ($activities as $activity) : ?>
                        <li class="list-group-item ">
                            <div class="container-fluid ">
                                <div class="my-2 row align-items-center justify-content-between">
                                    <div class="col-md-9 text-left">
                                        <?php echo $activity['name']; ?>
                                    </div>
                                    <div class="col-md-3 text-center">
                                        <?php if ($activity['status_id'] != 3): ?>
                                            <form action="app.php" method="POST">
                                                <input type="hidden" name="advance_assignment" value="1">
                                                <input type="hidden" name="assignment_id"
                                                       value="<?php echo $activity['id']; ?>">
                                                <button type="submit"
                                                        class="btn btn-primary"><?php echo Engine::getStatusName($activity['status_id']); ?>
                                                    <br>-><?php echo Engine::getStatusName($activity['status_id'] + 1); ?>
                                                </button>
                                            </form>
                                        <?php else: ?>
                                            <button disabled
                                                    class="btn btn-success"><?php echo Engine::getStatusName($activity['status_id']); ?></button>

                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 text-left">
                                        <?php echo $activity['description']; ?>
                                    </div>
                                </div>
                            </div>
                        </li>
                    <?php endforeach ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php else: ?>
    <!--Ne postoje dodeljene aktivnosti-->
    <div class="container my-3">
        <div class="row text-center">
            <div class="col-md-4">
                <h1 class="display-4">Detalji</h1>
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
                <?php
                $activities = Engine::getActivities($project_id);
                ?>
                <h1 class="display-4">Aktivnosti</h1>
                <?php if (!empty($activities)): ?>
                    <?php foreach ($activities as $activity) : ?>
                        <li class="list-group-item ">
                            <div class="container-fluid ">
                                <div class="my-2 row align-items-center justify-content-between">
                                    <div class="col-md-9 text-left">
                                        <?php echo $activity['name']; ?>
                                    </div>
                                    <div class="col-md-3 text-center">

                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 text-left">
                                        <?php echo $activity['description']; ?>
                                    </div>
                                </div>
                            </div>
                        </li>

                    <?php endforeach ?>
                <?php else: ?>
                    <h1 class="lead">Za ovaj projekat ne postoje unete aktivnosti. Prilikom konkurisanja mozete
                        konkurisati za ceo projekat.</h1>
                    <form action="app.php" method="POST">
                        <input name="project_application" type="hidden" value="1">
                        <input name="project_id" type="hidden" value="<?php echo $project_id; ?>">
                        <input name="activity_id" type="hidden" value="">

                        <button class="btn btn-success" type="submit">Prijavi se za projekat</button>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php endif; ?>
</body>

</html>