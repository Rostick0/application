<?

class ProjectAccessController {
    public static function getMy($project_id) {
        $project_id = (int) $project_id;
        $user_id = (int) $_SESSION['user']['user_id'];

        return ProjectAccess::getMy($project_id, $user_id);
    }

    public static function create($project_id, $name, $user_id) {
        $project_id = (int) $project_id;
        $user_id = (int) $user_id;

        if (!$project_id) return "Не выбран проект";

        if (!$user_id) return "Не выбран пользователь";

        return ProjectAccess::create($project_id, $name, $user_id);
    }

    public static function check($data, $access_name, $access_array) {
        if (is_null($data) || is_null($access_array)) return false;

        return array_search($access_name, $access_array) !== false;
    }

    public static function edit($project_id, $name, $user_id) {
        $project_id = (int) $project_id;
        $user_id = (int) $user_id;

        $user_email = DbQuery::parse('user', 'user_id', $user_id, 'email');

        $user_editor_access = ProjectAccess::get($project_id, $_SESSION['user']['user_id'])->fetch_assoc();
        $user_editor_access_name = json_decode($user_editor_access['name'], true);

        if (!$user_editor_access) return "Нет доступа";

        if (!ProjectAccessController::check('', 'all', $user_editor_access_name) && !ProjectAccessController::check('', 'edit_role', $user_editor_access_name)) return "Нет доступа";

        if ($name === NULL) return "Невыбран доступ";

        if (strpos($name, 'all') !== false) {
            $name = json_encode(["all"]);
        }

        $name_protected = [];

        foreach ($name as $value) {
            $name_protected[] = DbQuery::replacingQuotes($value);
        }

        $name_protected = json_encode($name_protected);

        if (ProjectAccess::get($project_id, $user_id)->num_rows > 0) {
            ProjectAccess::update($project_id, $name_protected, $user_id);
        } else {
            ProjectAccess::create($project_id, $name_protected, $user_id);
        }

        ProjectHistoryEditController::create('Добавил роль ' . $user_email, null, $user_email, 'add', $project_id, $_SESSION['user']['user_id']);
    }
}

?>