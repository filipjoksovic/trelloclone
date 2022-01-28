<?php
require "Engine.php";

session_start();

if (isset($_POST['register'])) {

    //get data for inserting into the db
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role_id = $_POST['role_id'];
//    check if form data is valid
    if (Engine::validateRequest($_POST) == false) {
        $_SESSION['error'] = "Molimo popunite sve podatke u formi.";
        header("location:register.php");
        return;
    }
    //check if user exists and handle accordingly
    if (Engine::userExists($email)) {
        $_SESSION['error'] = "Korisnik sa zadatim parametrima vec postoji. Izmenite podatke i pokusajte ponovo.";
        header("location:register.php");
    } else {
        $result = Engine::createUser($fname, $lname, $email, $password, $role_id);
        //log in on successful registration
        if ($result) {
            $_SESSION['uid'] = $result;
            $_SESSION['role_id'] = $role_id;
            $_SESSION['email'] = $email;
            $_SESSION['fname'] = $fname;
            $_SESSION['lname'] = $lname;
            $_SESSION['message'] = "Uspesno prijavljivanje. Dobrodosli, {$fname} {$lname}!";
            //handle redirects depending on the role
            // 1 - user
            // 2 - manager
            // 3 - admin
            if ($role_id == 1) {
                header("location:home.php");
                return;
            } else if ($role_id == 2) {
                header("location:manager.php");
                return;
            } else if ($role_id == 3) {
                header("location:admin.php");
                return;
            }
        } //handle error when registering
        else {
            $_SESSION['error'] = $result;
            header("location:register.php");
        }
    }
}

if (isset($_POST['login'])) {
    if (Engine::validateRequest($_POST) == false) {
        $_SESSION['error'] = "Molimo ispunite sve podatke u formi";
        header("location:login.php");
        return;
    }
    $email = $_POST['email'];
    $password = $_POST['password'];
    $user_id = Engine::attemptLogin($email, $password);
    if ($user_id == -1) {
        $_SESSION['error'] = "Neispravni podaci. Proverite podatke i pokusajte ponovo.";
        header("location:login.php");
        return;
    } else {
        $user = Engine::getUser($user_id);
        $_SESSION['email'] = $user['email'];
        $_SESSION["fname"] = $user['fname'];
        $_SESSION['lname'] = $user['lname'];
        $_SESSION['uid'] = $user['id'];
        $_SESSION['role_id'] = $user['role_id'];
        $_SESSION['message'] = "Uspesno prijavljivanje. Dobrodosli, {$user['fname']} {$user['lname']}";
        if ($user['role_id'] == "1") {
            header("location:home.php");
            return;
        } else if ($user['role_id'] == "2") {
            header("location:manager.php");
            return;
        } else if ($user['role_id'] == "3") {
            header("location:admin.php");
            return;
        }
    }
}
if (isset($_GET['logout'])) {
    session_destroy();
    header("location:login.php");
}
//allows the admin to delete the user
if (isset($_GET['delete_user'])) {
    if (!isset($_SESSION['role_id']) || $_SESSION['role_id'] != 3) {
        $_SESSION['error'] = "Nemate dozvolu pristupa ovom delu sajta.";
        header("location:home.php");
        return;
    }
    $user_id = $_GET['delete_user'];
    $result = Engine::deleteUser($user_id);
    if ($result == -1) {
        $_SESSION['error'] = "Doslo je do greske prilikom brisanja korisnika.";
        header("location:admin.php");
        return;
    } else {
        $_SESSION['message'] = "Korisnik je uspesno obrisan";
        header("location:admin.php");
        return;
    }
}
//allows admin to update the user
if (isset($_POST['edit_user'])) {
    if (!isset($_SESSION['role_id']) || $_SESSION['role_id'] != 3) {
        $_SESSION['error'] = "Nemate dozvolu pristupa ovom delu sajta.";
        header("location:home.php");
        return;
    }
    //get the data from post
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    //get the old email so we can find the user to edit
    $oldEmail = $_POST['oldEmail'];
    $result = Engine::editUser($fname, $lname, $email, $oldEmail);
    if ($result == -1) {
        $_SESSION['error'] = "Doslo je do greske prilikom izmene korisnika.";
        header("location:admin.php");
    } else {
        $_SESSION['message'] = "Uspesno izmenjen korisnik.";
        header("location:admin.php");
    }
}
//allows the admin to create a user
//basically the same logic as register just with different redirects and messages
if (isset($_POST['createUser'])) {
    if (!isset($_SESSION['role_id']) || $_SESSION['role_id'] != 3) {
        $_SESSION['error'] = "Nemate dozvolu pristupa ovom delu sajta.";
        header("location:home.php");
        return;
    }
    //get data for inserting into the db
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role_id = $_POST['role_id'];
//    check if form data is valid
    if (Engine::validateRequest($_POST) == false) {
        $_SESSION['error'] = "Molimo popunite sve podatke u formi.";
        header("location:createUser.php");
        return;
    }
    //check if user exists and handle accordingly
    if (Engine::userExists($email)) {
        $_SESSION['error'] = "Korisnik sa zadatim parametrima vec postoji. Izmenite podatke i pokusajte ponovo.";
        header("location:createUser.php");
    } else {
        $result = Engine::createUser($fname, $lname, $email, $password, $role_id);
        //log in on successful registration
        if ($result) {
            $_SESSION['message'] = "Uspesno kreiran korisnik.";
            //handle redirects depending on the role
            header("location:admin.php");
        } //handle error when registering
        else {
            $_SESSION['error'] = $result;
            header("location:createUser.php");
        }
    }
}

