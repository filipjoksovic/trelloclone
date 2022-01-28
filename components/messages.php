<?php
if (session_status() == false) {
    session_start();
}
?>

<?php if (isset($_SESSION['error'])) : ?>
    <div id="errorContainer">
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Greska</strong> <?php echo $_SESSION['error'] ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    </div>
    <?php $_SESSION['error'] = null; ?>
<?php endif ?>

<?php if (isset($_SESSION['message'])): ?>
    <div id="messageContainer">
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Uspeh!</strong> <?php echo $_SESSION['message'] ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    </div>
    <?php $_SESSION['message'] = null; ?>
<?php endif ?>

