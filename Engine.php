<?php

class Engine
{
//    itrerate through request array to check and find empty fields
    static function validateRequest($request)
    {
        foreach ($request as $value) {
            if ($value == "" || $value == " " || $value == null) {
                return false;
            }
        }
        return true;
    }

    //connect to the db
    static function connect()
    {
        $host = "localhost";
        $username = "root";
        $password = "";
        $database = "trelloclone";
        return mysqli_connect($host, $username, $password, $database);
    }

    //check if user exists in the database
    static function userExists($email)
    {
        $connection = Engine::connect();
        $query = "SELECT * FROM users where email = '{$email}'";
        $rows = $connection->query($query);
        if ($rows->num_rows > 0) {
            return true;
        }
        return false;
    }

    //create a user and store it into database
    static function createUser($fname, $lname, $email, $password, $role_id)
    {
        $connection = Engine::connect();
        $password = md5($password);
        $query = "INSERT into users(fname, lname, email, password, role_id) VALUES('{$fname}','{$lname}','{$email}','{$password}',{$role_id})";
        if ($connection->query($query) === TRUE) {
            return true;
        } else {
//            in case of error return that error
            return $connection->error;
        }
    }

    //return all roles from the db
    static function getRoles()
    {
        $connection = Engine::connect();
        $query = "SELECT * from roles";
        $rows = $connection->query($query)->fetch_all(MYSQLI_ASSOC);
        return $rows;
    }

    public static function attemptLogin($email, $password)
    {
        $connection = Engine::connect();
        //limit to one user so we can just get one assoc array
        $hashed_password = md5($password);
        $query = "SELECT * FROM users where email = '{$email}' AND password = '{$hashed_password}' LIMIT 1";
        $rows = $connection->query($query);
        //if user not found return -1
        if ($rows->num_rows == 0) {
            return -1;
        } else {
            //if user found form an assoc array and return just the id
            $user = $rows->fetch_assoc();
            return $user['id'];
        }
    }

    public static function getUser($user_id)
    {
        $connection = Engine::connect();
        $query = "SELECT * from users where id = {$user_id} LIMIT 1";
        $rows = $connection->query($query);
        if ($rows->num_rows > 0) {
            return $rows->fetch_assoc();
        } else {
            return -1;
        }

    }

    public static function getUsers()
    {
        $connection = Engine::connect();
        $query = "SELECT * FROM users";
        $result = $connection->query($query)->fetch_all(MYSQLI_ASSOC);
        return $result;
    }

    public static function editUser($fname, $lname, $email,$oldEmail)
    {
        $connection = Engine::connect();
        $query = "UPDATE users set fname = '{$fname}', lname = '{$lname}', email = '{$email}' where email = '{$oldEmail}'";
        if ($connection->query($query) != TRUE) {
            return -1;
        }
        return 1;
    }

    public static function deleteUser($user_id)
    {
        $connection = Engine::connect();
        $query = "DELETE from users where id = {$user_id}";
        if ($connection->query($query) === TRUE) {
            return 1;
        }
        return -1;
    }
}

?>