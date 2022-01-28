<?php
if (session_status() == FALSE) {
    session_start();
}
if (!isset($_SESSION['uid']) || $_SESSION['uid'] != null) {
    header("location:login.php");
} else {
    header("location:home.php");
}



?>