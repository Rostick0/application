<?

class ProjectController {
    public static function get($status_date, $is_ready, $limit, $offset, $type = null) {
        $status_date = implode(', ', DbQuery::setIntInArray($status_date));
        $is_ready = $is_ready ? 1 : null;
        $limit = (int) $limit;
        $offset = (int) $offset;
        
        if ($type == 'count') {
            return Project::getCount($status_date, $is_ready);
        }

        return Project::get($status_date, $is_ready, $limit, $offset);
    }

    public static function search($name, $project_id, $status_date, $is_ready, $limit, $offset, $type = null) {
        $name = DbQuery::protectedData($name);
        $project_id = (int) $project_id;
        $status_date = implode(', ', DbQuery::setIntInArray($status_date));
        $is_ready = $is_ready ? 1 : null;
        $limit = (int) $limit;
        $offset = (int) $offset;

        if ($type == 'count') return Project::searchCount($name, $project_id, $is_ready, $status_date);

        return Project::search($name, $project_id, $status_date, $is_ready, $limit, $offset);
    }

    public static function getMy($limit, $offset, $type = null) {
        $user_id = (int) $_SESSION['user']['user_id'];
        $limit = (int) $limit;
        $offset = (int) $offset;

        if ($type == 'count') return Project::getMyCount($user_id);

        return Project::getMy($user_id, $limit, $offset);
    }

    public static function create($name, $contract, $address, $inn, $start_date, $end_date, $delivery_date, $comment, $complaint, $zmo_id, $is_made_order, $document_scan, $documents, $is_ready = 0, $products) {
        $name = DbQuery::protectedData($name);
        $contract = DbQuery::protectedData($contract);
        $address = DbQuery::protectedData($address);
        $inn = (int) $inn;
        $start_date = DateEditor::normalizeDateSql($start_date);
        $end_date = DateEditor::normalizeDateSql($end_date);
        $delivery_date = DateEditor::normalizeDateSql($delivery_date);
        $comment = DbQuery::protectedData($comment);
        $complaint = DbQuery::protectedData($complaint);
        $documents = $documents ? 1 : 0;
        $is_made_order = $is_made_order ? 1 : 0;
        $document_scan = $document_scan ? 1 : 0;
        $is_ready = $is_ready ? 1 : 0;

        $user_role = DbQuery::parse('user', 'user_id', $_SESSION['user']['user_id'], 'role_id');

        $user_power = DbQuery::parse('role', 'role_id', $user_role, 'power');

        if ($user_power < 25) return "Создание недоступно для вас";

        $project_id = Project::create($name, $contract, $address, $inn, $start_date, $end_date, $delivery_date, $comment, $complaint, $zmo_id, $is_made_order, $document_scan, $documents, $is_ready);
        ProjectAccessController::create($project_id, json_encode(['all']), $_SESSION['user']['user_id']);
        ProjectHistoryEditController::create('Создал проект ' . $project_id, null, null, 'create', $project_id, $_SESSION['user']['user_id']);

        if ($delivery_date) ProjectController::setStatusDate($project_id, $delivery_date, $is_ready);

        ProductController::addProducts($project_id, $products);

        header("Location: /project?id=$project_id");
    }

    public static function edit($project_id, $name, $contract, $address, $inn, $start_date, $end_date, $delivery_date, $comment, $complaint, $zmo_id, $is_made_order, $document_scan, $documents, $products, $access_array) {
        $project_id = (int) $project_id;
        $name = DbQuery::protectedData($name);
        $contract = DbQuery::protectedData($contract);
        $address = DbQuery::protectedData($address);
        $inn = (int) $inn;
        $start_date = $start_date ? DateEditor::normalizeDateSql($start_date) : "";
        $end_date = $end_date ? DateEditor::normalizeDateSql($end_date) : "";
        $delivery_date = $delivery_date ? DateEditor::normalizeDateSql($delivery_date) : "";
        $comment = DbQuery::protectedData($comment);
        $complaint = DbQuery::protectedData($complaint);
        $zmo_id = (int) $zmo_id;
        $is_made_order = $is_made_order ? 1 : 0;
        $document_scan = $document_scan ? 1 : 0;
        $documents = $documents ? 1 : 0;

        $data_type = compact(
            'name',
            'contract',
            'inn',
            'start_date',
            'end_date',
            'delivery_date',
            'comment',
            'complaint',
            'zmo_id',
            'is_made_order',
            'document_scan',
            'documents'
        );

        $project_old = DbQuery::get('project', 'project_id', $project_id)->fetch_assoc();

        $action_edit = [];

        $user_power = (int) DbQuery::parse('role', 'role_id', $_SESSION['user']['role_id'], 'power');

        foreach ($data_type as $type => $value) {
            if ($access_array[0] != 'all' || $user_power < 20) {
                if (!ProjectAccessController::check($value, $type, $access_array)) {
                    $data_type[$type] = $project_old[$type];
                    continue;
                }
            }

            if (!checkEdited($project_old[$type], $data_type[$type])) {
                $action_edit[] = [
                    'name' => $type,
                    'old' => DbQuery::protectedData($project_old[$type]),
                    'new' => DbQuery::protectedData($data_type[$type])
                ];
            }
        }

        $query = Project::edit($project_id, $data_type['name'], $data_type['contract'], $data_type['address'], $data_type['inn'], $data_type['start_date'], $data_type['end_date'], $data_type['delivery_date'], $data_type['comment'], $data_type['complaint'], $data_type['zmo_id'], $data_type['is_made_order'], $data_type['document_scan'], $data_type['documents']);

        if (!$query) return "Ошибка при изменении данных";

        if ($data_type['delivery_date'] == $delivery_date) ProjectController::setStatusDate($project_id, $data_type['delivery_date'], $data_type['is_ready']);

        if (count($action_edit) > 1) {
            foreach ($action_edit as $action) {
                ProjectHistoryEditController::create('Изменил поле ' . $action['name'], $action['old'], $action['new'], 'edit', $project_id, $_SESSION['user']['user_id']);
            }
        }

        ProductController::addOrEditProducts($project_id, $products);

        header('Refresh: 0');
    }

    public static function setReady($project_id, $is_ready) {
        $project_id = (int) $project_id;
        $is_ready = $is_ready ? 1 : 0;

        if ($is_ready == 0) {
            Project::setReady($project_id, $is_ready);
            return;
        }

        $project_data = DbQuery::get('project', 'project_id', $project_id)->fetch_assoc();

        $error_text = "Нельзя сделать проект готовым, пока ";

        if (strlen($project_data['name']) < 3) return $error_text . "название компании меньше 3 символов";

        if (!$project_data['inn']) return $error_text . "Отсуствует ИНН";

        Project::setReady($project_id, $is_ready);
    }

    public static function setStatusDate($project_id, $date_delivery, $is_ready) {
        if ($is_ready) return;

        if (!$date_delivery) return;

        $status_date = 1;
        $today = strtotime(date('y-m-d'));

        if ((strtotime($date_delivery)) - $today <= 172800) {
            $status_date = 2;
        }

        if (strtotime($date_delivery) < $today) {
            $status_date = 3;
        }

        Project::setStatusDate($project_id, $status_date);
    }

    public static function checkDate($start_date, $is_ready) {
        if ($is_ready) return 'green lighten-3';

        if (!$start_date) return;

        if (time() - (strtotime($start_date)) / 60 * 60 * 24 * 2 <= 2) return 'yellow lighten-3';

        return 'red lighten-3';
    }

    public static function colorProject($delivery_status, $is_ready)
    {
        if ($is_ready) return 'green lighten-3';

        if (!$delivery_status) return;

        if ($delivery_status == 2) return 'yellow lighten-3';

        if ($delivery_status == 3) return 'red lighten-3';
    }

    public static function delete($project_id, $access_array) {
        $project_id = (int) $project_id;

        $user_power = (int) DbQuery::parse('role', 'role_id', $_SESSION['user']['role_id'], 'power');

        if ($access_array[0] != 'all' || $user_power < 20 || array_search('project_delete', $access_array) !== false) return "Ошибка при удалении";

        $query = Project::delete($project_id);

        if (!$query) return "Ошибка при удалении";

        ProjectHistoryEditController::create('Удалил проект ' . $project_id, null, null, 'delete', $project_id, $_SESSION['user']['user_id']);
        header('Location: /');
    }
}

?>