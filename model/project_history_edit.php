<?

class ProjectHistoryEdit {
    public static function create($name, $old, $new, $type, $project_id, $user_id) {
        global $db_connect;

        $old = !empty($old) ? "'$old'" : "NULL";
        $new = !empty($new) ? "'$new'" : "NULL";
        
        $query = $db_connect->query("INSERT INTO `project_history_edit`(`name`, `old`, `new`, `type`, `project_id`, `user_id`) VALUES ('$name', $old, $new, '$type', '$project_id','$user_id')");

        return $query;
    }

    public static function search($name, $project_id, $limit, $offset) {
        global $db_connect;

        $name = !empty($name) ? "'%$name%'" : "NULL";
        $project_id = !empty($project_id) ? "'%$project_id%'" : "NULL";

        $query = $db_connect->query("SELECT * FROM `project_history_edit`
        WHERE `project_id` IN (SELECT `project_id` FROM `project` WHERE `name` LIKE $name)
        UNION SELECT * FROM `project_history_edit`
        WHERE `project_id` IN (SELECT `project_id` FROM `project` WHERE `project_id` LIKE $project_id) LIMIT $limit OFFSET $offset");

        return $query;
    }
}

?>