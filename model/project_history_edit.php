<?

class ProjectHistoryEdit {
    public static function create($action, $project_id, $user_id) {
        global $db_connect;
        
        return $db_connect->query("INSERT INTO `project_history_edit`(`action`, `project_id`, `user_id`) VALUES ('$action','$project_id','$user_id')");;
    }
}

?>