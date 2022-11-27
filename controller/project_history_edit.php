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

    public static function get($status_date, $is_ready, $limit, $offset, $type = null) {
        $status_date = implode(', ', DbQuery::setIntInArray($status_date));
        $is_ready = $is_ready ? 1 : null;
        $limit = (int) $limit;
        $offset = (int) $offset;
        
        if ($type == 'count') {
            return ProjectHistoryEdit::getCount($status_date, $is_ready);
        }

        return ProjectHistoryEdit::get($status_date, $is_ready, $limit, $offset);
    }

    public static function search($name, $project_id, $status_date, $is_ready, $limit, $offset, $type = null) {
        $name = DbQuery::protectedData($name);
        $project_id = (int) $project_id;
        $status_date = implode(', ', DbQuery::setIntInArray($status_date));
        $is_ready = $is_ready ? 1 : null;
        $limit = (int) $limit;
        $offset = (int) $offset;

        if ($type == 'count') {
            return ProjectHistoryEdit::searchCount($name, $project_id, $status_date, $is_ready);
        }

        return ProjectHistoryEdit::search($name, $project_id, $status_date, $is_ready, $limit, $offset);
    }
}

?>