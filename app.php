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
//handle the creation of a project
if ($_POST['create_project']) {
    //check if the user is a manager
    if (!isset($_SESSION['role_id']) || $_SESSION['role_id'] != 2) {
        $_SESSION['error'] = "Nemate dozvolu pristupa ovom delu sajta.";
        header("location:home.php");
        return;
    }
    //get form data
    $name = $_POST['name'];
    $location = $_POST['location'];
    $description = $_POST['description'];
    $benefits = $_POST['benefits'];
    $education_level = $_POST['education_level'];
    $deadline = $_POST['deadline'];
    //handle creation on a separate file
    $result = Engine::createProject($name, $location, $description, $benefits, $education_level, $deadline, $_SESSION['uid']);
    //handle redirects
    if ($result == 1) {
        $_SESSION['message'] = "Uspesno kreiran projekat";
        header("location:manager.php");
        return;
    } else {
        $_SESSION['error'] = "Doslo je do greske prilikom kreiranja projekta";
        header("location:manager.php");
        return;
    }
}
//handle the creation of the activities
if ($_POST['create_activity']) {
    if (!isset($_SESSION['role_id']) || $_SESSION['role_id'] != 2) {
        $_SESSION['error'] = "Nemate dozvolu pristupa ovom delu sajta.";
        header("location:home.php");
        return;
    }
    $name = $_POST['name'];
    $description = $_POST['description'];
    $project_id = $_POST['project_id'];
    if (Engine::projectExists($project_id) == false) {
        $_SESSION['error'] = "Projekat sa zadatom sifrom ne postoji. Proverite podatke i pokusajte ponovo.";
        header("location:manager.php");
    } else {
        $result = Engine::createActivity($project_id, $name, $description);
        if ($result == -1) {
            $_SESSION['error'] = "Doslo je do greske prilikom kreiranja projektne aktivnosti.";
            header("location:projectDetails.php?id={$project_id}");
            return;
        } else {
            $_SESSION['message'] = "Uspesno kreirana projektna aktivnost.";
            header("location:projectDetails.php?id={$project_id}");
            return;
        }
    }
}
if ($_POST['project_application']) {
    $project_id = $_POST['project_id'];
    $activity_id = $_POST['activity_id'];
    $user_id = $_SESSION['uid'];
    if (!Engine::checkForApplication($user_id, $project_id)) {
        $result = Engine::applyForProject($user_id, $project_id, $activity_id);
        if ($result == 1) {
            $_SESSION['message'] = "Uspesno prijavljivanje na projekat. Po pregledu menadzera moci cete da upravljate dodeljenjim aktivnostima.";
            header("location:home.php");
        } else {
            $_SESSION['error'] = "Doslo je do greske prilikom prijavljivanja na projekat. Greska: " . $result;
            header("location:home.php");
            return;
        }
    }
    else{
        $_SESSION['error'] = "Vec ste prijavljeni za ovaj projekat.";
        header("location:home.php");
        return;
    }
}
