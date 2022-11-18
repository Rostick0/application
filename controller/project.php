<?

class ProjectController {
    public static function create($name, $address, $inn, $start_date, $end_date, $count, $count_defective, $price, $price_commission, $comment, $complaint, $is_ready, $status_payment_id, $status_delivery_id) {
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
        $is_ready = (boolean) $is_ready;
        $status_payment_id = (int) $status_payment_id;
        $status_delivery_id = (int) $status_delivery_id;
        
        // if (strlen($name) < 3) return "Название компании меньше 3 символов";

        // if (!$address) return "Не указан адрес";

        // if (!$start_date) return "Отсуствует дата начала проекта";

        // if (!$end_date) return "Отсуствует дата окончания проекта";

        // if (!$price) return "Нет стоимости";

        Project::create($name, $address, $inn, $start_date, $end_date, $count, $count_defective, $price, $price_commission, $comment, $complaint, $is_ready, $status_payment_id, $status_delivery_id);
    }
}

?>