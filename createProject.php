<?php
require "Engine.php";
$roles = Engine::getRoles();
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Trelloclone - Kreiraj projekat</title>
    <?php include("components/scripts.php") ?>
</head>
<body>
<?php include("components/nav.php") ?>

<div class="container my-3">
    <h1>Kreiraj projekat</h1>
    <form action="app.php" method="POST">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="name">Ime projekta</label>
                    <input type="text" class="form-control" name="name" id="name">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="location">Lokacija</label>
                    <input type="text" class="form-control" name="location" id="location">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="description">Opis</label>
                    <textarea class="form-control" name="description" id="description"></textarea>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="benefits">Pogodnosti zaposlenih</label>
                    <textarea class="form-control" name="benefits" id="benefits"></textarea>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="education_level">Strucna sprema</label>
                    <select class="form-control" name="education_level" id="education_level">
                        <option value="IV">IV - Srednja skola</option>
                        <option value="V">V - Visokokvalifikovani radnik</option>
                        <option value="VI-1">VI-1 - Osnovne akademske studije</option>
                        <option value="VI-2">VI-2 - Specijalisticke strukovne studije</option>
                        <option value="VII-1">VII-1 - Master akademske studije</option>
                        <option value="VII-2">VII-2 - Specijalisticke akademske studije</option>
                        <option value="VIII">VIII - Doktorske studije</option>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="deadline">Rok prijave</label>
                    <input type="date" class="form-control" name="deadline" id="deadline">
                </div>
            </div>
        </div>
        <input type="hidden" name="create_project" value="1">
        <button type="submit" class="btn btn-primary">Kreiraj aktivnost</button>
    </form>

</div>
</body>
</html>