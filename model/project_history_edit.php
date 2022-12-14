<?

class ProjectHistoryEdit {
    public static function create($name, $old, $new, $type, $project_id, $user_id) {
        global $db_connect;

        $old = !empty($old) ? "'$old'" : "NULL";
        $new = !empty($new) ? "'$new'" : "NULL";
        
        $query = $db_connect->query("INSERT INTO `project_history_edit`(`name`, `old`, `new`, `type`, `project_id`, `user_id`) VALUES ('$name', $old, $new, '$type', '$project_id','$user_id')");

        return $query;
    }

    public static function get($status_date, $is_ready, $limit, $offset) {
        global $db_connect;

        $sql_add = "WHERE";

        if ($status_date) $sql_add .= " `project_id` IN (SELECT `project_id` FROM `project` WHERE `status_date` in ($status_date)) AND";

        if ($is_ready) $sql_add .= " `project_id` = (SELECT `project_id` FROM `project` WHERE `is_ready` in ($is_ready)) AND";

        if ($sql_add != "WHERE") {
            $sql_add = substr($sql_add, 0, -4);
        } else {
            $sql_add = "";
        }

        return $db_connect->query("SELECT * FROM `project_history_edit` $sql_add ORDER BY `project_history_edit_id` DESC LIMIT $limit OFFSET $offset");
    }

    public static function getCount($status_date, $is_ready) {
        global $db_connect;

        $sql_add = "WHERE";

        if ($status_date) $sql_add = " `project_id` IN (SELECT `project_id` FROM `project` WHERE `status_date` in ($status_date)) AND";

        if ($is_ready) $sql_add .= " `project_id` = (SELECT `project_id` FROM `project` WHERE `is_ready` in ($is_ready)) AND";

        if ($sql_add != "WHERE") {
            $sql_add = substr($sql_add, 0, -4);
        } else {
            $sql_add = "";
        }

        return $db_connect->query("SELECT COUNT(*) FROM `project_history_edit` $sql_add ORDER BY `project_history_edit_id`")->fetch_assoc()["COUNT(*)"];
    }

    public static function search($name, $project_id, $status_date, $is_ready, $limit, $offset) {
        global $db_connect;

        $sql_add = "";

        if ($status_date) $sql_add = "AND `project_id` IN (SELECT `project_id` FROM `project` WHERE `status_date` in ($status_date))";

        if ($is_ready) $sql_add .= " AND `project_id` = (SELECT `project_id` FROM `project` WHERE `is_ready` in ($is_ready))";

        $name = !empty($name) ? "'%$name%'" : "NULL";
        $project_id = !empty($project_id) ? "'%$project_id%'" : "NULL";

        $query = $db_connect->query("SELECT * FROM `project_history_edit`
        WHERE `project_id` IN (SELECT `project_id` FROM `project` WHERE `name` LIKE $name $sql_add)
        UNION SELECT * FROM `project_history_edit`
        WHERE `project_id` IN (SELECT `project_id` FROM `project` WHERE `project_id` LIKE $project_id $sql_add) ORDER BY `project_history_edit_id` DESC LIMIT $limit OFFSET $offset");

        return $query;
    }

    public static function searchCount($name, $project_id, $status_date, $is_ready) {
        global $db_connect;

        $sql_add = "";

        if ($status_date) {
            $sql_add = "AND `project_id` IN (SELECT `project_id` FROM `project` WHERE `status_date` in ($status_date))";
        }

        if ($is_ready) {
            $sql_add .= " AND `project_id` = (SELECT `project_id` FROM `project` WHERE `is_ready` in ($is_ready))";
        }

        $name = !empty($name) ? "'%$name%'" : "NULL";
        $project_id = !empty($project_id) ? "'%$project_id%'" : "NULL";

        $query = $db_connect->query("SELECT COUNT(*) FROM
        (
            SELECT * FROM `project_history_edit` WHERE `project_id` IN (SELECT `project_id` FROM `project` WHERE `name` LIKE $name) $sql_add
            UNION
            SELECT * FROM `project_history_edit` WHERE `project_id` IN (SELECT `project_id` FROM `project` WHERE `project_id` LIKE $project_id) $sql_add
        )
        
        `counter`");

        return $query->fetch_assoc()["COUNT(*)"];
    }
}

?>