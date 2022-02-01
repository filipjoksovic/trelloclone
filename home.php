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
    <?php include("userMiddleware.php");?>
    <?php
    require "Engine.php";
    $activities = Engine::getAssignedActivities($_SESSION['uid']);
    $assignedProjects = Engine::getAssignedProjects($_SESSION['uid']);
    $statuses = Engine::getStatuses();
    ?>
    <?php
    if (isset($_GET['search'])) {
        $searchText = null;
        $project_id = null;
        $project_statuses = null;
        $status_select = null;
        $status_sort = null;
        $deadline_sort = null;
        if (isset($_GET['search_text'])) {
            $searchText = $_GET['search_text'];
        }
        if (isset($_GET['project_id'])) {
            $project_id = $_GET['project_id'];
        }
        if (isset($_GET['status_select'])) {
            $status_select = $_GET['status_select'];
        }
        if (isset($_GET['deadline_sort'])) {
            $deadline_sort = $_GET['deadline_sort'];
        }
        if (isset($_GET['status_sort'])) {
            $status_sort = $_GET['status_sort'];
        }
        if ($searchText != null) {
            foreach ($activities as $key => $activity) {
                if (!strpos($activity['name'], $searchText)) {
                    unset($activities[$key]);
                }
            }
        }
        if ($project_id != null) {
            foreach ($activities as $key => $activity) {
                if ($activity['pid'] != $project_id) {
                    unset($activities[$key]);
                }
            }
        }
        if ($status_select != null) {
            foreach ($activities as $key => $activity) {
                if (!in_array($activity['sid'],$status_select)) {
                    unset($activities[$key]);
                }
            }
        }
        if($status_sort != null){
            $deadline_sort = null;
            if($status_sort == "asc"){
            usort($activities, function ($item1, $item2) {
                        return $item1['sid'] <=> $item2['sid'];
                    });
            }
            else{
                usort($activities, function ($item1, $item2) {
                    return $item2['sid'] <=> $item1['sid'];
                });
            }
        }
        if($deadline_sort != null){
            $status_sort = null;
            function date_compare($a, $b)
            {
                $t1 = strtotime($a['deadline']);
                $t2 = strtotime($b['deadline']);
                
                return $t1 - $t2;
            }   
            usort($activities, 'date_compare');
            
        }
 
    }
    ?>

    <div class="container my-3">
        <div class="row">
            <div class="col-md-3">
                <form action="home.php" method="GET">
                    <h1 class="display-4 text-center mb-3">Pretraga</h1>
                    <div class="form-group">
                        <label for="project_name">Ime aktivnosti</label>
                        <input type="text" name="search_text" id="project_name" class="form-control" <?php if (isset($_GET['search_text'])) : ?>value="<?php echo $_GET['search_text']; ?>" <?php endif; ?>>
                    </div>
                    <div class="card my-3 border-primary">
                        <div class="card-header">
                            Ime projekta
                        </div>
                        <div class="card-body">
                            <select class="form-control" id="project_name" name="project_id">
                                <option value="" selected>Odaberi</option>
                                <?php foreach ($assignedProjects as $project) : ?>
                                    <option value="<?php echo $project['id']; ?>"><?php echo $project['name']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="card my-3 border-primary">
                        <div class="card-header">
                            Status projekta
                        </div>
                        <div class="card-body">
                            <?php foreach ($statuses as $status) : ?>
                                <div class="form-check">
                                    <input class="form-check-input" name="status_select[]" <?php if(isset($status_select) && in_array($status['id'],$status_select)):?>checked <?php endif;?>type="checkbox" value="<?php echo $status['id']; ?>" id="defaultCheck<?php echo $status['id']; ?>">
                                    <label class="form-check-label" for="defaultCheck<?php echo $status['id']; ?>">
                                        <?php echo $status['name']; ?>
                                    </label>
                                </div>
                            <?php endforeach; ?>

                        </div>
                    </div>
                    <div class="form-group">
                        <label for="status_sort">Sortiraj po statusu: </label>
                        <select class="form-control" name="status_sort" id="status_sort">
                            <option value="" selected>Ne sortiraj</option>
                            <option value="asc" <?php if(isset($_GET['status_sort']) && $status_sort == 'asc'):?> selected <?php endif;?>>Rastuce</option>
                            <option value="desc" <?php if(isset($_GET['status_sort']) && $status_sort == 'desc'):?> selected <?php endif;?>>Opadajuce</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="status_sort">Sortiraj po krajnjem roku: </label>
                        <select class="form-control" name="deadline_sort" id="deadline_sort">
                            <option value="" selected>Ne sortiraj</option>
                            <option value="asc" <?php if(isset($_GET['deadline_sort']) && $deadline_sort == 'asc'):?> selected <?php endif;?>>Rastuce</option>
                            <option value="desc" <?php if(isset($_GET['deadline_sort']) && $deadline_sort == 'asc'):?> selected <?php endif;?>>Opadajuce</option>
                        </select>
                    </div>
                    <input type="hidden" name="search" value="1">
                    <button type="submit" class="btn btn-success btn-block">Pretrazi</button>
                </form>
            </div>
            <div class="col-md-9">
                <h1 class="display-4 text-center mb-3">Dodeljene projektne aktivnosti
                </h1>
                <div class="row">
                    <?php foreach ($activities as $activity) : ?>
                        <div class="col-md-6">
                            <div class="card my-2">
                                <div class="card-body">
                                    <h4 class="card-title"><?php echo $activity['name']; ?> <span class="badge badge-primary"><?php echo $activity['status']; ?></span>
                                    </h4>
                                    <p class="card-text">Opis: <?php echo $activity['description']; ?></p>
                                    <p class="card-text">Rok: <?php echo  date("d-m-Y", strtotime($activity['deadline'])); ?></p>
                                    <a href="details.php?id=<?php echo $activity['pid']; ?>">Detalji</a>
                                </div>
                                <div class="card-footer">
                                    <div class="d-flex w-100 justify-content-around">
                                        <p>Projekat:<br><?php echo $activity['pname']; ?></p>
                                        <p class = "text-right">Datum dodele:<br><?php echo date("d-m-Y", strtotime($activity['updated_at'])); ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach ?>
                </div>
            </div>
        </div>
    </div>


</body>

</html>