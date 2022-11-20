<?

class ProjectAccess {
    public static function getMy($project_id, $user_id) {
        global $db_connect;

        return $db_connect->query("SELECT * FROM `project_access` WHERE `project_id` = '$project_id' AND `user_id` = '$user_id'");
    }

    public static function create($project_id, $name, $role_id, $user_id) {
        global $db_connect;

        return $db_connect->query("INSERT INTO
        `project_access`(`project_id`, `name`, `role_id`, `user_id`)
        VALUES
        ('$project_id','$name','$role_id','$user_id')");
    }
}

?>