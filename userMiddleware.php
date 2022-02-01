<?php 
    if($_SESSION['role_id'] != 1){
        $_SESSION['error'] = "Nemate ovlascenje pristupa ovom delu sajta";
        header("location:login.php");
    }
?>