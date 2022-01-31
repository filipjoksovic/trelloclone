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
<div class="container my-3">
    <div class="row text-center">
        <div class="col-md-4">
            <h1 class="display-4">Detalji aktivnosti</h1>
            <div class="container-fluid">
                <p class="lead font-weight-bold">Naziv projekta:</p>
                <p class="lead"><?php echo $activity['name']; ?></p>
                <p class="lead font-weight-bold">Opis:</p>
                <p class="lead"><?php echo $activity['description']; ?></p>
            </div>
        </div>
        <div class="col-md-8">
            <?php if ($_SESSION['role_id'] == 1): ?>
                <?php if (!Engine::commentExists($activity_id, $_SESSION['uid'])): ?>
                    <h1 class="display-4">Ostavi komentar</h1>
                    <form action="app.php" method="POST">
                        <input type="hidden" name="leave_comment" value=1>
                        <input type="hidden" name="activity_id" value="<?php echo $activity_id; ?>">
                        <div class="form-group">
                            <label for="comment-text">Komentar</label>
                            <textarea name="comment_text" id="comment-text" class="form-control"></textarea>
                        </div>
                        <button type="submit" class="btn btn-success btn-block w-50 mx-auto">Ostavi komentar</button>
                    </form>
                <?php else: ?>
                    <h1 class="display-4">Postavljeni komentari</h1>
                    <?php
                    $comments = Engine::getComments($activity_id, $_SESSION['uid']);
                    ?>
                    <?php foreach ($comments as $comment): ?>
                        <div class="card my-2">
                            <div class="card-header">
                                <div class="d-flex w-100 justify-content-between">
                                    <p><?php echo $comment['fname'] . " " . $comment['lname']; ?>  - <i><?php echo $comment['email'];?></i></p>
                                    <p><?php echo $comment['updated_at']; ?></p>
                                </div>
                            </div>
                            <div class="card-body text-left">
                                <?php echo $comment['comment_text']; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    <p class="lead my-3">Ostavi komentar</p>
                    <form action="app.php" method="POST">
                        <input type="hidden" name="leave_comment" value=1>
                        <input type="hidden" name="activity_id" value="<?php echo $activity_id; ?>">
                        <div class="form-group">
                            <label for="comment-text">Komentar</label>
                            <textarea name="comment_text" id="comment-text" class="form-control"></textarea>
                        </div>
                        <button type="submit" class="btn btn-success btn-block w-50 mx-auto">Ostavi komentar</button>
                    </form>
                <?php endif; ?>

            <?php elseif ($_SESSION['role_id'] == 2): ?>
                <h1 class="display-4">Ostavljeni komentari</h1>
                <h1 class="display-4">Postavljeni komentari</h1>
                <?php
                $comments = Engine::getCommentsForManager($activity_id);
                ?>
                <?php foreach ($comments as $comment): ?>
                    <div class="card my-2">
                        <div class="card-header">
                            <div class="d-flex w-100 justify-content-between">
                                <p><?php echo $comment['fname'] . " " . $comment['lname']; ?> - <i><?php echo $comment['email'];?></i></p>
                                <p><?php echo $comment['updated_at']; ?></p>
                            </div>
                        </div>
                        <div class="card-body text-left">
                            <?php echo $comment['comment_text']; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
                <p class="lead my-3">Odgovor na komentar</p>
                <form action="app.php" method="POST">
                    <input type="hidden" name="leave_comment" value=1>
                    <input type="hidden" name="activity_id" value="<?php echo $activity_id; ?>">
                    <div class="form-group">
                        <label for="comment-text">Komentar</label>
                        <textarea name="comment_text" id="comment-text" class="form-control"></textarea>
                    </div>
                    <button type="submit" class="btn btn-success btn-block w-50 mx-auto">Odgovori na komentare</button>
                </form>
            <?php endif; ?>
        </div>
    </div>
</div>
</body>

</html>