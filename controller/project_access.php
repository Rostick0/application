<?

class ProjectAccessController {
    public static function getMy($project_id) {
        $project_id = (int) $project_id;
        $user_id = (int) $_SESSION['user']['user_id'];

        return ProjectAccess::getMy($project_id, $user_id);
    }

    public static function create($project_id, $name, $role_id, $user_id) {
        $project_id = (int) $project_id;
        $name = json_encode(DbQuery::replacingQuotes($name));
        $role_id = (int) $role_id;
        $user_id = (int) $user_id;

        

        if (!$project_id) return "Не выбран проект";

        if (!$role_id) $role_id = 1;

        if (!$user_id) return "Не выбран пользователь";

        return ProjectAccess::create($project_id, $name, $role_id, $user_id);
    }

    public static function check($data, $access_name, $access_array) {
        if (is_null($data) || is_null($access_array)) return false;

        return array_search($access_name, $access_array) !== false;
    }
}

?>