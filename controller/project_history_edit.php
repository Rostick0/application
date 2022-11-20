<?

class ProjectHistoryEditController {
    public static function create($action, $project_id, $user_id) {
        $action = json_encode($action);
        $project_id = (int) $project_id;
        $user_id = (int) $user_id;

        ProjectHistoryEdit::create($action, $project_id, $user_id);
    }
}

?>