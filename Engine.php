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
            return $connection->insert_id;
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
            $user = $rows->fetch_array(MYSQLI_ASSOC);
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

    public static function editUser($fname, $lname, $email, $oldEmail)
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

    public static function createProject($name, $location, $description, $benefits, $education_level, $deadline, $user_id)
    {
        $connection = Engine::connect();
        $query = "INSERT into projects(name, description, location, education_level, benefits, deadline, manager_id) VALUES ('{$name}','{$description}','{$location}','{$education_level}','{$benefits}','{$deadline}',{$user_id})";
        if ($connection->query($query) === TRUE) {
            return 1;
        } else {
            return -1;
        }
    }

    //get all projects
    static function getAllProjects()
    {
        $connection = Engine::connect();
        $query = "SELECT * from projects";
        $result = $connection->query($query);
        if ($result->num_rows == 0) {
            return [];
        }
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // get the project from the id
    static function getProject($project_id)
    {
        $connection = Engine::connect();
        $query = "SELECT * from projects where id = {$project_id}";
        $result = $connection->query($query);
        if ($result->num_rows == 0) {
            return null;
        } else {
            return $result->fetch_assoc();
        }
    }

    static function getActivities($project_id)
    {
        $connection = Engine::connect();
        $query = "SELECT * from project_activities where project_id = {$project_id}";
        $result = $connection->query($query);
        if ($result->num_rows == 0) {
            return [];
        } else {
            return $result->fetch_all(MYSQLI_ASSOC);
        }
    }

    static function projectExists($project_id)
    {
        return (Engine::getProject($project_id) == null) ? false : true;
    }

    static function createActivity($project_id, $name, $description)
    {
        $connection = Engine::connect();
        $query = "INSERT into project_activities(project_id,name,description) values({$project_id},'{$name}','{$description}')";
        if ($connection->query($query) === TRUE) {
            return 1;
        }
        return -1;
    }

    static function countComments($activity_id)
    {
        return 0;
    }

    static function countApplications($activity_id)
    {
        return 0;
    }


    public static function getStatusName($status_id)
    {
        if ($status_id > 3) {
            $status_id = 3;
        }
        $connection = Engine::connect();
        $query = "SELECT name from activity_statuses where id = {$status_id}";
        $result = $connection->query($query);
        if ($result->num_rows > 0) {
            return $result->fetch_array()[0];
        }
        return null;
    }


    public static function getActivity($activity_id)
    {
        $connection = Engine::connect();
        $query = "SELECT project_activities.* FROM project_activities where id = {$activity_id} LIMIT 1";
        $result = $connection->query($query);
        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        }
        return [];
    }

    public static function getUnassignedActivities($project_id)
    {
        $connection = Engine::connect();
        $query = "SELECT * from project_activities where project_id = {$project_id} and status_id is null";
        $result = $connection->query($query);
        if ($result->num_rows == 0) {
            return [];
        } else {
            return $result->fetch_all(MYSQLI_ASSOC);
        }
    }


    public static function getRegularUsers()
    {
        $connection = Engine::connect();
        $query = "SELECT * FROM users where role_id = 1";
        $result = $connection->query($query);
        if ($result->num_rows > 0) {
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        return [];
    }

    public static function assignActivity($user_id, $activity_id)
    {
        $connection = Engine::connect();
        $query = "UPDATE project_activities set user_id = {$user_id}, status_id = 1 where id = {$activity_id}";
        if ($connection->query($query) === TRUE) {
            return 1;
        }
        return $connection->error;
    }

    public static function getAssignedActivities($user_id)
    {
        $connection = Engine::connect();
        $query = "SELECT p.name as 'pname',p.id as 'pid',project_activities.name,project_activities.id as 'aid',project_activities.description,project_activities.updated_at,project_activities.status_id,activity_statuses.name as 'status' FROM project_activities INNER JOIN activity_statuses on project_activities.status_id = activity_statuses.id INNER JOIN projects p on project_activities.project_id = p.id where project_activities.user_id = {$user_id}";
        $result = $connection->query($query);
        if ($connection->query($query)->num_rows > 0) {
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        return [];
    }

    public static function checkForAssignments($uid, $project_id)
    {
        $connection = Engine::connect();
        $query = "SELECT * from project_activities where user_id = {$uid} and project_id = {$project_id}";
        $result = $connection->query($query);
        if ($result->num_rows > 0) {
            return true;
        }
        return false;
    }

    public static function advanceAssignment($assignment_id)
    {
        $connection = Engine::connect();
        $fquery = "SELECT status_id from project_activities where id = {$assignment_id} limit 1";
        $result = $connection->query($fquery);
        if ($result != null) {
            $status_id = $result->fetch_assoc()['status_id'];
            $status_id++;
            if ($status_id > 3) {
                $status_id = 3;
            }
            $query = "UPDATE project_activities SET status_id = {$status_id} where id = {$assignment_id}";
            if ($connection->query($query) === TRUE) {
                return 1;
            }
            return $connection->error;
        }
        return $connection->error . " " . $fquery;
    }

}
