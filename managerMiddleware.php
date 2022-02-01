<?php 
    if($_SESSION['role_id'] != 2){
        $_SESSION['error'] = "Nemate ovlascenje pristupa ovom delu sajta";
        header("location:home.php");
    }
?>