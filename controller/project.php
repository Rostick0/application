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

    public static function edit($project_id, $name, $address, $inn, $start_date, $end_date, $count, $count_defective, $price, $price_commission, $comment, $complaint, $status_payment_id, $status_delivery_id) {
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
        $status_payment_id = (int) $status_payment_id;
        $status_delivery_id = (int) $status_delivery_id;

        if (strlen($name) < 3) return "Название компании меньше 3 символов";

        if (!$address) return "Не указан адрес";

        if (!$inn) return "Отсуствует ИНН";

        Project::edit($project_id, $name, $address, $inn, $start_date, $end_date, $count, $count_defective, $price, $price_commission, $comment, $complaint, $status_payment_id, $status_delivery_id);
    }
}

?>