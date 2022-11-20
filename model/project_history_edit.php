<?

class ProjectHistoryEdit {
    public static function create($action, $project_id, $user_id) {
        global $db_connect;

        $query = $db_connect->query("INSERT INTO `project_history_edit`(`action`, `project_id`, `user_id`) VALUES ('$action','$project_id','$user_id')");
    
        var_dump($db_connect->error);
        
        return $query;
    }
}

?>