<?

class ProjectHistoryEditController {
    public static function create($name, $old, $new, $type, $project_id, $user_id) {
        $name = DbQuery::protectedData($name);
        $old = DbQuery::protectedData($old);
        $new = DbQuery::protectedData($new);
        $type = DbQuery::protectedData($type);
        $project_id = (int) $project_id;
        $user_id = (int) $user_id;

        ProjectHistoryEdit::create($name, $old, $new, $type, $project_id, $user_id);
    }

    public static function search($name, $project_id, $limit, $offset) {
        $name = DbQuery::protectedData($name);
        $project_id = (int) $project_id;
        $limit = (int) $limit;
        $offset = (int) $offset;

        return ProjectHistoryEdit::search($name, $project_id, $limit, $offset);
    }
}

?>