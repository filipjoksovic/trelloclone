<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TrelloClone - Edit Project</title>
    <?php include("components/scripts.php"); ?>
</head>

<body>
    <?php include("components/nav.php"); ?>
    <?php require "Engine.php"; ?>
    <?php
    $project_id = $_GET['id'];
    $project = Engine::getProject($project_id);
    ?>
    <div class="container my-3">
        <h1 class="display-4">Izmeni projekat</h1>
        <form action="app.php" method="POST">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="name">Ime projekta</label>
                        <input type="text" class="form-control" name="name" id="name" value="<?php echo $project['name']; ?>">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="location">Lokacija</label>
                        <input type="text" class="form-control" name="location" id="location" value="<?php echo $project['location']; ?>">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="description">Opis</label>
                        <textarea class="form-control" name="description" id="description"><?php echo $project['description']; ?></textarea>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="benefits">Pogodnosti zaposlenih</label>
                        <textarea class="form-control" name="benefits" id="benefits"> <?php echo $project['benefits']; ?></textarea>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="education_level">Strucna sprema</label>
                        <select class="form-control" name="education_level" id="education_level">
                            <option value="IV" <?php if ($project['education_level'] == "IV") echo "selected"; ?>>IV - Srednja skola</option>
                            <option value="V" <?php if ($project['education_level'] == "V") echo "selected"; ?>>V - Visokokvalifikovani radnik</option>
                            <option value="VI-1" <?php if ($project['education_level'] == "VI-1") echo "selected"; ?>>VI-1 - Osnovne akademske studije</option>
                            <option value="VI-2" <?php if ($project['education_level'] == "VI-2") echo "selected"; ?>>VI-2 - Specijalisticke strukovne studije</option>
                            <option value="VII-1" <?php if ($project['education_level'] == "VII-1") echo "selected"; ?>>VII-1 - Master akademske studije</option>
                            <option value="VII-2" <?php if ($project['education_level'] == "VII-2") echo "selected"; ?>>VII-2 - Specijalisticke akademske studije</option>
                            <option value="VIII" <?php if ($project['education_level'] == "VIII") echo "selected"; ?>>VIII - Doktorske studije</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="deadline">Rok prijave</label>
                        <input type="date" class="form-control" name="deadline" id="deadline" value=<?php echo $project['deadline']; ?>>
                    </div>
                </div>
            </div>
            <input type="hidden" name="project_id" value="<?php echo $project['id']; ?>">
            <input type="hidden" name="edit_project" value="1">
            <button type="submit" class="btn btn-primary">Izmeni projekat</button>
        </form>
    </div>
</body>

</html>