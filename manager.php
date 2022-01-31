<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Trelloclone - Manager</title>
    <?php include("components/scripts.php") ?>
</head>
<body>
<?php include("components/nav.php") ?>
<?php
require "Engine.php";

$connection = Engine::connect();
$query = "SELECT * from projects where manager_id = {$_SESSION['uid']}";
$projects = $connection->query($query)->fetch_all(MYSQLI_ASSOC);
?>
<div class="container my-3">
    <h1>Prikaz projekata</h1>
    <div class="row">
        <?php foreach ($projects as $project): ?>
            <div class="col-md-6">
                <div class="card my-2">
                    <div class="card-header">
                        <?php echo $project['name']; ?>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <p class="text-center"><?php echo $project['description']; ?></p>
                            </div>
                            <div class="col-md-6">
                                <p class="text-center"><?php echo $project['benefits']; ?></p>

                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <p class="text-center"><?php echo $project['location']; ?></p>
                            </div>
                            <div class="col-md-6">
                                <p class="text-center"><?php echo $project['education_level']; ?></p>

                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-md-4 text-center">
                                <a href="projectDetails.php?id=<?php echo $project['id']; ?>"
                                   class="btn btn-primary">Detalji</a>
                            </div>
                            <div class="col-md-4 text-center">
                                <a href="editProject.php?id=<?php echo $project['id']; ?>" class="btn btn-warning">Izmeni</a>
                            </div>
                            <div class="col-md-4">
                                <form action="app.php" method="POST">
                                    <input type="hidden" name="delete_project" value = "1">
                                    <input type="hidden" name="project_id" value="<?php echo $project['id']; ?>">
                                    <button type="submit" class="btn btn-danger mx-auto d-block">Ukloni</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
</body>
</html>