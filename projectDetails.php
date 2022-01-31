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
                <div class="d-flex flex-column justify-content-between h-100">
                    <h1 class="display-4">Aktivnosti</h1>
                    <?php if ($activities == null) : ?>
                        <p>Nemate trenutno dodatih aktivnosti za ovaj projekat.</p>
                    <?php else : ?>
                        <div class="card">
                            <ul class="list-group list-group-flush">
                                <?php foreach ($activities  as $activity) : ?>
                                    <li class="list-group-item">
                                        <div class="container-fluid">
                                            <div class="my-2 row align-items-center justify-content-between">
                                                <div class="col-md-9 text-left">
                                                    <?php echo $activity['name']; ?>
                                                </div>
                                                <div class="col-md-3">
                                                    <a class="btn btn-primary" href="activityDetails.php?id=<?php echo $activity['id']; ?>">Detalji</a>
                                                </div>
                                            </div>
                                            <div class="my-2 row align-items-center justify-content-between">
                                                <div class="col-md-8 text-left">
                                                    <p>Broj komentara: <?php echo Engine::countComments($activity['id']); ?></p>
                                                </div>
                                                <div class="col-md-4">
                                                    <p>Broj konkursa: <?php echo Engine::countApplications($activity['id']); ?></p>
                                                </div>
                                            </div>
                                        </div>
                                    </li>

                                <?php endforeach ?>
                            </ul>
                        </div>

                    <?php endif; ?>
                    <a class="btn btn-success w-50 d-block mx-auto" href="addActivity.php?id=<?php echo $project_id; ?>">Dodajte aktivnost</a>
                </div>
            </div>
            <div class="col-md-4">
                <h1 class="display-4">Prijave</h1>
                <?php
                $applications = Engine::getApplications($project_id);
                ?>
                <?php foreach ($applications as $application) : ?>
                    <div class="card text-left">
                        <div class="card-body">
                            <h4 class="card-title"><?php echo $application['fname'] . " " . $application['lname']; ?></h4>
                            <p class="card-text"><?php echo ($application['name'] != null)? $application['name'] : "Ceo projekat"; ?></p>
                        </div>
                        <div class = "card-footer">
                            <form action = "app.php" method = "POST">
                                <input type = "hidden" name = "allow_application" value = "1">
                                <input type = "hidden" name = "application_id" value = "<?php echo $application['id'];?>">
                                <button type = "submit" class = "btn btn-success">Odobri</button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>

            </div>
        </div>
    </div>
</body>

</html>