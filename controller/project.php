<?

class ProjectController {
    public static function getMy() {
        $user_id = (int) $_SESSION['user']['user_id'];

        return Project::getMy($user_id);
    }

    public static function create($name, $address, $inn, $start_date, $end_date, $count, $count_defective, $price, $price_commission, $comment, $complaint, $is_ready = 0, $status_payment_id, $status_delivery_id) {
        $name = DbQuery::protectedData($name);
        $address = DbQuery::protectedData($address);
        $inn = (int) $inn;
        $start_date = DateEditor::normalizeDateSql($start_date);
        $end_date = DateEditor::normalizeDateSql($end_date);
        $count = (int) $count;
        $$count_defective = (int) $$count_defective;
        $price = (float) $price;
        $price_commission = (float) $price_commission;
        $comment = DbQuery::protectedData($comment);
        $complaint = DbQuery::protectedData($complaint);
        $is_ready = $is_ready ? 1 : 0;
        $status_payment_id = (int) $status_payment_id;
        $status_delivery_id = (int) $status_delivery_id;

        if (strlen($name) < 3) return "Название компании меньше 3 символов";

        if (!$address) return "Не указан адрес";

        if (!$inn) return "Отсуствует ИНН";

        $user_role = DbQuery::parse('user', 'user_id', $_SESSION['user']['user_id'], 'role_id');

        $user_power = DbQuery::parse('role', 'role_id', $user_role, 'power');

        if ($user_power < 5) return "Создание недоступно для вас";

        $project_id = Project::create($name, $address, $inn, $start_date, $end_date, $count, $count_defective, $price, $price_commission, $comment, $complaint, $is_ready, $status_payment_id, $status_delivery_id);
        ProjectAccessController::create($project_id, 'all', 2, $_SESSION['user']['user_id']);
    }

    public static function edit($project_id, $name, $address, $inn, $start_date, $end_date, $count, $count_defective, $price, $price_commission, $comment, $complaint, $status_payment_id, $status_delivery_id, $access_array) {
        $project_id = (int) $project_id;
        $name = DbQuery::replacingQuotes($name);
        $address = DbQuery::replacingQuotes($address);
        $inn = (int) $inn;
        $start_date = $start_date ? DateEditor::normalizeDateSql($start_date) : "";
        $end_date = $end_date ? DateEditor::normalizeDateSql($end_date) : "";
        $count = (int) $count;
        $count_defective = (int) $count_defective;
        $price = (float) $price;
        $price_commission = (float) $price_commission;
        $comment = DbQuery::replacingQuotes($comment);
        $complaint = DbQuery::replacingQuotes($complaint);
        $status_payment_id = (int) $status_payment_id;
        $status_delivery_id = (int) $status_delivery_id;

        $data_type = compact(
            'name',
            'address',
            'inn',
            'start_date',
            'end_date',
            'count',
            'count_defective',
            'price',
            'price_commission',
            'comment',
            'complaint',
            'status_payment_id',
            'status_delivery_id'
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
                    'old' => DbQuery::replacingQuotes($project_old[$type]),
                    'new' => DbQuery::replacingQuotes($data_type[$type])
                ];
            }
        }

        if (strlen($data_type['name']) < 3) return "Название компании меньше 3 символов";

        if (!$data_type['address']) return "Не указан адрес";

        if (!$data_type['inn']) return "Отсуствует ИНН";

        $query = Project::edit($project_id, $data_type['name'], $data_type['address'], $data_type['inn'], $data_type['start_date'], $data_type['end_date'], $data_type['count'], $data_type['count_defective'], $data_type['price'], $data_type['price_commission'], $data_type['comment'], $data_type['complaint'], $data_type['status_payment_id'], $data_type['status_delivery_id']);

        if (!$query) return "Ошибка при изменении данных";

        if (count($action_edit) < 1) return;

        ProjectHistoryEditController::create($action_edit, $project_id, $_SESSION['user']['user_id']);
    }

    public static function setReady($project_id, $is_ready) {
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

        if (!$project_data['count']) return $error_text . "не указано количество";

        if (!$project_data['price']) return $error_text . "не указана цена";

        Project::setReady($project_id, $is_ready);
    }

    public static function checkEdited($old, $new) {
        if (is_null($old) && is_null($new)) return false;

        return $old == $new;
    }

    public static function renderEditInput($acces_array, $user_power) {
        
    }
}

?>