<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Trelloclone - Detalji o projektu</title>
    <?php include("components/scripts.php") ?>
</head>

<body>
    <?php include("components/nav.php") ?>
    <?php require("managerMiddleware.php");?>
    <?php
    require "Engine.php";
    $project_id = $_GET['id'];
    $project = Engine::getProject($project_id);
    if ($project == null) {
        $_SESSION['error'] = "Projekat sa datom sifrom ne postoji u bazi podataka";
        header("location:manager.php");
        return;
    }
    $unassignedActivities = Engine::getUnassignedProjectActivities($project_id);
    $assignedActivities = Engine::getAssignedProjectActivities($project_id);

    ?>
    <div class="container-fluid p-5 my-3">
        <div class="row text-center">
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
            <div class="col-md-4">
                <div class="">
                    <h1 class="display-4">Nedodeljene Aktivnosti</h1>
                    <?php if ($unassignedActivities == null) : ?>
                        <p>Nemate trenutno dodatih aktivnosti za ovaj projekat.</p>
                    <?php else : ?>
                        <div class="card">
                            <ul class="list-group list-group-flush">
                                <?php foreach ($unassignedActivities as $activity) : ?>
                                    <li class="list-group-item">
                                        <div class="container-fluid">
                                            <div class="my-2 row align-items-center justify-content-between">
                                                <div class="col-md-9 text-left">
                                                    <?php echo $activity['name']; ?>
                                                </div>
                                                <div class="col-md-3">
                                                    <a class="btn btn-primary" href="assignActivity.php?id=<?php echo $activity['aid']; ?>">Dodeli
                                                        aktivnost</a>

                                                </div>
                                            </div>
                                        </div>
                                    </li>

                                <?php endforeach ?>
                            </ul>
                        </div>

                    <?php endif; ?>
                    <div class="d-flex w-100 justify-content-around">
                        <a class="btn btn-success  my-3" href="addActivity.php?id=<?php echo $project_id; ?>">Dodajte
                            aktivnost</a>
                        <a href="assignProject.php?id=<?php echo $project_id; ?>" class="btn btn-primary  my-3">Dodelite ceo projekat</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="">
                    <h1 class="display-4">Dodeljene Aktivnosti</h1>
                    <?php if ($assignedActivities == null) : ?>
                        <p>Nemate trenutno dodeljenih aktivnosti za ovaj projekat.</p>
                    <?php else : ?>
                        <div class="card my-1">
                            <?php foreach ($assignedActivities as $activity) : ?>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">
                                        <div class="container-fluid">
                                            <div class="my-2 row align-items-center justify-content-between">
                                                <div class="col-md-9 text-left">
                                                    <p><?php echo $activity['name']; ?></p>
                                                    <p>Preuzeo: <?php echo $activity['fname'] . " " . $activity['lname']; ?>
                                                    </p>
                                                </div>
                                                <div class="col-md-3">
                                                    <button class="btn btn-sm btn-primary" disabled><?php echo $activity['status']; ?></button>
                                                    <a href="comments.php?id=<?php echo $activity['aid']; ?>">Komentari</a>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                <?php endforeach ?>
                                </ul>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</body>

</html>