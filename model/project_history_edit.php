<?

class ProjectHistoryEdit {
    public static function create($name, $old, $new, $project_id, $user_id) {
        global $db_connect;

        $old = !empty($old) ? "'$old'" : "NULL";
        $new = !empty($new) ? "'$new'" : "NULL";
        
        return $db_connect->query("INSERT INTO `project_history_edit`(`name`, `old`, `new`, `project_id`, `user_id`) VALUES ('$name', '$old', '$new', '$project_id','$user_id')");;
    }
}

?>