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
            return null;
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

    static function checkForApplication($user_id, $project_id)
    {
        $connection = Engine::connect();
        $query = "SELECT * FROM project_applications where user_id = {$user_id} and project_id = {$project_id} and allowed = 0";
        $result = $connection->query($query);
        if ($result != null) {
            return true;
        }
        return false;
    }

    static function checkForAllowedApplication($user_id, $project_id)
    {
        $connection = Engine::connect();
        $query = "SELECT * FROM project_applications where user_id = {$user_id} and project_id = {$project_id} and allowed = 1";
        $result = $connection->query($query);
        if ($result->num_rows > 0) {
            return true;
        }
        return false;
    }

    static function checkForDeniedApplication($user_id, $project_id)
    {
        $connection = Engine::connect();
        $query = "SELECT * from project_applications where user_id not {$user_id} and project_id = {$project_id} and allowed = 1";
        $result = $connection->query($query);
        if ($result != null) {
            return true;
        }
        return false;
    }

    static function applyForProject($user_id, $project_id, $activity_id = null)
    {
        $connection = Engine::connect();
        if ($activity_id != null) {
            $query = "INSERT INTO project_applications(user_id,project_id,activity_id) VALUES ({$user_id},{$project_id},{$activity_id})";
            if ($connection->query($query) === TRUE) {
                return 1;
            }
            return $connection->error;
        } else {
            $query = "INSERT INTO project_applications(user_id,project_id) VALUES ({$user_id},{$project_id})";
            if ($connection->query($query) === TRUE) {
                return 1;
            }
            return $connection->error;
        }
    }

    static function getApplications($project_id)
    {
        $connection = Engine::connect();
        $query = "SELECT project_activities.id,project_activities.name,users.fname,users.lname,project_applications.created_at FROM project_applications INNER JOIN projects on projects.id = project_applications.id LEFT JOIN project_activities on project_applications.activity_id = project_activities.id INNER JOIN users on users.id = project_applications.user_id WHERE project_applications.project_id = {$project_id}";
        $result = $connection->query($query);
        if ($result != null) {
            return $result->fetch_all(MYSQLI_ASSOC);
        } else {
            return [];
        }
    }

    static function allowApplication($application_id)
    {
        $connection = Engine::connect();
        $query = "UPDATE project_applications set allowed = 1, status_id = 1 where id = {$application_id}";
        if ($connection->query($query) === TRUE) {
            return 1;
        } else {
            return $connection->error;
        }
    }

    static function projectAssigned($user_id, $project_id)
    {
        $connection = Engine::connect();
        $query = "SELECT * FROM project_applications where allowed = 1 and project_id = {$project_id} and user_id = {$user_id} and activity_id is NULL";
        $result = $connection->query($query);
        if ($result->num_rows > 0) {
            return true;
        }
        return false;
    }

    static function activitiesAssigned($user_id, $project_id)
    {
        $connection = Engine::connect();
        $query = "SELECT * FROM project_applications where allowed = 1 and project_id = {$project_id} and user_id = {$user_id} and activity_id is not null";
        $result = $connection->query($query);
        if ($result != null) {
            return true;
        }
        return false;
    }

    static function getAssignedActivities($user_id, $project_id)
    {
        $connection = Engine::connect();
        $query = "SELECT project_activities.*,project_applications.*,activity_statuses.name as 'sname' from project_applications INNER JOIN activity_statuses on activity_statuses.id = project_applications.status_id INNER JOIN project_activities on project_applications.activity_id = project_activities.id where project_applications.project_id = {$project_id} and user_id = {$user_id} and allowed = 1";
        $result = $connection->query($query);
        if ($result != null) {
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        return [];
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

    public static function getAssignmentStatus($assignment_id)
    {
        $connection = Engine::connect();
        $query = "SELECT status_id FROM project_applications where id = {$assignment_id}";
        $result = $connection->query($query);
        if ($result->num_rows > 0) {
            return $result->fetch_array()[0];
        }
        return 1;
    }

    public static function advanceAssignment($assignment_id)
    {
        $status_id = Engine::getAssignmentStatus($assignment_id);
        $status_id++;
        if ($status_id > 3) {
            $status_id = 3;
        }
        $connection = Engine::connect();
        $query = "UPDATE project_applications set status_id = {$status_id} where id={$assignment_id}";
        if ($connection->query($query) === TRUE) {
            return 1;
        }
        return $connection->error;
    }

    public static function getResponsibleForActivity($id)
    {
        $connection = Engine::connect();
        $query = "SELECT u.* from project_applications inner join users u on project_applications.user_id = u.id where activity_id = {$id} LIMIT 1";
        $results = $connection->query($query);
        if ($results->num_rows > 0) {
            return $results->fetch_assoc();
        }
        return [];
    }

    public static function activityAssigned($id)
    {
        $connection = Engine::connect();
        $query = "SELECT * FROM project_applications where activity_id={$id} and allowed = 1";
        $result = $connection->query($query);
        if ($result->num_rows > 0) {
            return true;
        }
        return false;
    }

    public static function getActivityStatus($project_id, $id)
    {
        $connection = Engine::connect();
        $query = "SELECT activity_statuses.name FROM project_applications INNER JOIN activity_statuses on project_applications.status_id = activity_statuses.id where project_applications.project_id = {$project_id} and project_applications.activity_id = {$id} and allowed = 1";
        $result = $connection->query($query);
        if ($result->num_rows > 0) {
            return $result->fetch_array(MYSQLI_NUM)[0];
        }
        return null;
    }
}
