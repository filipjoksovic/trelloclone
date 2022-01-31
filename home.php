<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Trelloclone - Home</title>
    <?php include("components/scripts.php") ?>
</head>

<body>
    <?php include("components/nav.php") ?>
    <?php
    require "Engine.php";
    $projects = Engine::getAllProjects();
    ?>
    <div class="container my-3">
        <h1 class="display-4 text-center mb-3">Dostupni projekti</h1>
        <div class="row">
            <?php foreach ($projects as $project) : ?>
                <div class="col-md-6">
                    <div class="card my-2">
                        <div class="card-body">
                            <h4 class="card-title"><?php echo $project['name']; ?>
                                <?php if (Engine::checkForAllowedApplication($_SESSION['uid'], $project['id'])) : ?>
                                    <span class="badge badge-success">Odobrena prijava</span>
                                <?php elseif (Engine::checkForDeniedApplication($_SESSION['uid'], $project['id'])) : ?>
                                    <span class="badge badge-danger">Odbijena prijava</span>
                                <?php elseif (Engine::checkForApplication($_SESSION['uid'], $project['id'])) : ?>
                                    <span class="badge badge-primary">Aktivna prijava</span>
                                <?php endif; ?>
                            </h4>
                            <p class="card-text">Opis: <?php echo $project['description']; ?></p>
                            <p class="card-text">Pogodnosti: <?php echo $project['benefits']; ?></p>
                            <p class="card-text">Stepen strucne spreme: <strong><?php echo $project['education_level']; ?></strong></p>
                            <a href="details.php?id=<?php echo $project['id']; ?>">Detalji</a>
                        </div>
                    </div>
                </div>
            <?php endforeach ?>
        </div>
    </div>


</body>

</html>