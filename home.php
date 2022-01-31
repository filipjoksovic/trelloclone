<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Trelloclone - Home</title>
    <?php include("components/scripts.php") ?>
</head>

<body>
<?php include("components/nav.php") ?>
<?php
require "Engine.php";
$activities = Engine::getAssignedActivities($_SESSION['uid']);
?>
<div class="container my-3">
    <h1 class="display-4 text-center mb-3">Dodeljene projektne aktivnosti
    </h1>
    <div class="row">
        <?php foreach ($activities as $activity) : ?>
            <div class="col-md-6">
                <div class="card my-2">
                    <div class="card-body">
                        <h4 class="card-title"><?php echo $activity['name']; ?> <span
                                    class="badge badge-primary"><?php echo $activity['status']; ?></span>
                        </h4>
                        <p class="card-text">Opis: <?php echo $activity['description']; ?></p>
                        <a href="details.php?id=<?php echo $activity['pid']; ?>">Detalji</a>
                    </div>
                    <div class="card-footer">
                        <div class="d-flex w-100 justify-content-around">
                            <p>Projekat: <?php echo $activity['pname']; ?></p>
                            <p>Aktivnost dodeljena: <?php echo date("d-m-Y", strtotime($activity['updated_at'])); ?></p>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach ?>
    </div>
</div>


</body>

</html>