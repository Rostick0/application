<?

class ProjectController
{
    public static function getMy()
    {
        $user_id = (int) $_SESSION['user']['user_id'];

        return Project::getMy($user_id);
    }

    public static function create($name, $contract, $address, $inn, $start_date, $end_date, $comment, $complaint, $zmo_id, $is_made_order, $document_scan, $documents, $is_ready = 0, $products)
    {
        $name = DbQuery::protectedData($name);
        $contract = DbQuery::protectedData($contract);
        //$address = DbQuery::protectedData($address);
        $inn = (int) $inn;
        $start_date = DateEditor::normalizeDateSql($start_date);
        $end_date = DateEditor::normalizeDateSql($end_date);
        $comment = DbQuery::protectedData($comment);
        $complaint = DbQuery::protectedData($complaint);
        $documents = $documents ? 1 : 0;
        $is_made_order = $is_made_order ? 1 : 0;
        $document_scan = $document_scan ? 1 : 0;
        $is_ready = $is_ready ? 1 : 0;

        if (strlen($name) < 3) return "Название компании меньше 3 символов";

        if (!$inn) return "Отсуствует ИНН";

        $user_role = DbQuery::parse('user', 'user_id', $_SESSION['user']['user_id'], 'role_id');

        $user_power = DbQuery::parse('role', 'role_id', $user_role, 'power');

        if ($user_power < 25) return "Создание недоступно для вас";

        $project_id = Project::create($name, $contract, $address, $inn, $start_date, $end_date, $comment, $complaint, $zmo_id, $is_made_order, $document_scan, $documents, $is_ready);
        ProjectAccessController::create($project_id, json_encode(['all']), $_SESSION['user']['user_id']);
        ProjectHistoryEditController::create('Создал проект ' . $project_id, null, null, $project_id, $_SESSION['user']['user_id']);

        if (!is_array($products[0])) return;

        for ($i = 0; $i < count($products[0]); $i++) {
            ProductController::create($products[0][$i], $products[1][$i], $products[2][$i], $products[3][$i], $products[4][$i], $products[5][$i], $products[6][$i], $products[7][$i], $products[8][$i], $products[9][$i], $products[10][$i], $project_id);
            ProjectHistoryEditController::create('Добавил товар ' . $products[0][$i], null, null, $project_id, $_SESSION['user']['user_id']);
        }
    }

    public static function edit($project_id, $name, $contract, $address, $inn, $start_date, $end_date, $comment, $complaint, $zmo_id, $is_made_order, $document_scan, $documents, $access_array)
    {
        $project_id = (int) $project_id;
        $name = DbQuery::protectedData($name);
        $contract = DbQuery::protectedData($contract);
        $address = DbQuery::protectedData($address);
        $inn = (int) $inn;
        $start_date = $start_date ? DateEditor::normalizeDateSql($start_date) : "";
        $end_date = $end_date ? DateEditor::normalizeDateSql($end_date) : "";
        $comment = DbQuery::protectedData($comment);
        $complaint = DbQuery::protectedData($complaint);
        $zmo_id = (int) $zmo_id;
        $is_made_order = $is_made_order ? 1 : 0;
        $document_scan = $document_scan ? 1 : 0;
        $documents = $documents ? 1 : 0;

        $data_type = compact(
            'name',
            'contract',
            'address',
            'inn',
            'start_date',
            'end_date',
            'comment',
            'complaint',
            'zmo_id',
            'is_made_order',
            'document_scan',
            'documents'
        );

        $access_array_name = json_decode($access_array['name'], true);

        $project_old = DbQuery::get('project', 'project_id', $project_id)->fetch_assoc();

        $action_edit = [];

        $user_power = DbQuery::parse('role', 'role_id', $_SESSION['user']['role_id'], 'power');

        foreach ($data_type as $type => $value) {
            if ($access_array_name[0] != 'all' || $user_power < 20) {
                if (!ProjectAccessController::check($value, $type, $access_array_name)) {
                    $data_type[$type] = $project_old[$type];
                    continue;
                }
            }

            if (!ProjectController::checkEdited($project_old[$type], $data_type[$type])) {
                $action_edit[] = [
                    'name' => $type,
                    'old' => DbQuery::protectedData($project_old[$type]),
                    'new' => DbQuery::protectedData($data_type[$type])
                ];
            }
        }

        if (strlen($data_type['name']) < 3) return "Название компании меньше 3 символов";

        if (!$data_type['address']) return "Не указан адрес";

        if (!$data_type['inn']) return "Отсуствует ИНН";

        $query = Project::edit($project_id, $data_type['name'], $data_type['contract'], $data_type['address'], $data_type['inn'], $data_type['start_date'], $data_type['end_date'], $data_type['comment'], $data_type['complaint'], $data_type['zmo_id'], $data_type['is_made_order'], $data_type['document_scan'], $data_type['documents']);

        if (!$query) return "Ошибка при изменении данных";

        if (count($action_edit) < 1) return;

        foreach ($action_edit as $action) {
            ProjectHistoryEditController::create($action['name'], $action['old'], $action['new'], $project_id, $_SESSION['user']['user_id']);
        }
    }

    public static function setReady($project_id, $is_ready)
    {
        $project_id = (int) $project_id;
        $is_ready = $is_ready ? 1 : 0;

        if ($is_ready = 0) {
            Project::setReady($project_id, $is_ready);
            return;
        }

        $project_data = DbQuery::get('project', 'project_id', $project_id)->fetch_assoc();

        $error_text = "Нельзя сделать проект готовым, пока ";

        if (strlen($project_data['name']) < 3) return $error_text . "название компании меньше 3 символов";

        if (!$project_data['address']) return $error_text . "Не указан адрес";

        if (!$project_data['inn']) return $error_text . "Отсуствует ИНН";

        if (!$project_data['start_date']) return $error_text . "отсуствует дата начала";

        if (!$project_data['end_date']) return $error_text . "отсуствует дата окончания";

        Project::setReady($project_id, $is_ready);
    }

    public static function checkEdited($old, $new)
    {
        if (is_null($old) && is_null($new)) return false;

        return $old == $new;
    }

    public static function renderEditInput($acces_array, $user_power)
    {
    }
}
