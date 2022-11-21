<?

class ProjectAccess {
    public static function getMy($project_id, $user_id) {
        global $db_connect;

        return $db_connect->query("SELECT * FROM `project_access` WHERE `project_id` = '$project_id' AND `user_id` = '$user_id'");
    }

    public static function get($project_id, $user_id) {
        global $db_connect;

        return $db_connect->query("SELECT * FROM `project_access` WHERE `project_id` = '$project_id' AND `user_id` = '$user_id'");
    }

    public static function create($project_id, $name, $user_id) {
        global $db_connect;

        return $db_connect->query("INSERT INTO
        `project_access`(`project_id`, `name`, `user_id`)
        VALUES
        ('$project_id','$name','$user_id')");
    }

    public static function update($project_id, $name, $user_id) {
        global $db_connect;

        $db_connect->query("UPDATE `project_access` SET `name`='$name' WHERE `project_id`='$project_id' AND `user_id`='$user_id'");

        var_dump($db_connect->error);
    }
}

?>