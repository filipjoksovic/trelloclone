<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TrelloClone - Add Activity</title>
    <?php include ("components/scripts.php");?>
</head>
<body>
    <?php include("components/nav.php");?>
    <?php
        require "Engine.php"; 
        $project_id = $_GET['id'];
        $project = Engine::getProject($project_id);
    ?>
    <div class = "container my-3">
        <h1>Dodajte aktivnost</h1>
        <form action = "app.php" method = "POST">
            <div class = "form-group">
                <label for = "name">Naziv aktivnosti</label> 
                <input class = "form-control" id = "name" name = "name">
            </div>
            <div class = "form-group">
                <label for = "description">Opis aktivnosti</label>
                <textarea class = "form-control" id = "description" name = "description"></textarea>
            </div>
            <input name = "project_id" type = "hidden" value = "<?php echo $project_id;?>">
            <input name = "create_activity" type = "hidden" value = "1">
            <button type = "submit" class = "btn btn-success btn-block w-50 mx-auto">Dodaj aktivnost</button>
        </form>
    </div>
</body>
</html>