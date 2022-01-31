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
$activity_id = $_GET['id'];
$activity = Engine::getActivity($activity_id);
if ($activity == null) {
    $_SESSION['error'] = "Projekat sa datom sifrom ne postoji u bazi podataka";
    header("location:manager.php");
    return;
}

?>
<div class="container-fluid p-5 my-3">
    <div class="row text-center">
        <div class="col-md-4">
            <h1 class="display-4">Detalji </h1>
            <div class="container-fluid">
                <p class="lead font-weight-bold">Naziv aktivnosti:</p>
                <p class="lead"><?php echo $activity['name']; ?></p>
                <p class="lead font-weight-bold">Opis:</p>
                <p class="lead"><?php echo $activity['description']; ?></p>
            </div>
            <?php if (Engine::activityAssigned($activity['id'])): ?>
                <div class="container-fluid">
                    <h1 class="display-4">Status aktivnosti</h1>
                    <p class="lead">Aktivnost dodeljena:
                        <strong><?php $user = Engine::getResponsibleForActivity($activity['id']);
                            echo $user['fname'] . " " . $user['lname']; ?></strong></p>
                    <p class="lead">Status aktivnosti:
                        <strong><?php echo Engine::getActivityStatus($activity_id); ?></strong></p>
                </div>
            <?php endif; ?>
        </div>
        <div class="col-md-5">
            <div class="d-flex flex-column justify-content-between h-100">
                <h1 class="display-4">Prijave</h1>
                <?php if (!Engine::getActivityStatus($activity_id)): ?>
                    <?php
                    $applications = Engine::getActivityApplications($activity_id);
                    ?>
                    <?php foreach ($applications as $application) : ?>
                        <div class="card text-left">
                            <div class="card-body">
                                <h4 class="card-title"><?php echo $application['fname'] . " " . $application['lname']; ?></h4>
                                <p class="card-text"><?php echo ($application['name'] != null) ? $application['name'] : "Ceo projekat"; ?></p>
                            </div>
                            <div class="card-footer">
                                <form action="app.php" method="POST">
                                    <input type="hidden" name="allow_application" value="1">
                                    <input type="hidden" name="application_id"
                                           value="<?php echo $application['id']; ?>">
                                    <button type="submit" class="btn btn-success">Odobri</button>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="lead">Aktivnost je zavrsena. Prijave nece biti prikazane.</p>
                <?php endif; ?>
            </div>

        </div>
        <div class="col-md-3">
            <h1 class="display-4">Manualno dodeljivanje aktivnosti</h1>
            <form action="app.php" method="POST">
                <input type="hidden" name="assign_activity" value="1">
                <div class="form-group">
                    <label for="email">Email korisnika</label>
                    <input type="email" name="email" id="email" class="form-control">
                </div>
                <button type="submit" class="btn btn-success">Dodeli aktivnost</button>
            </form>
        </div>
    </div>
</div>
</body>

</html>