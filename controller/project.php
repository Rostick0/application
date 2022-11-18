<?

class ProjectController {
    public static function create($name, $address, $inn, $start_date, $end_date, $count, $price, $price_commission, $comment, $is_ready, $status_payment_id, $status_delivery_id) {
        $name = DbQuery::protectedData($name);
        $address = DbQuery::protectedData($address);
        $inn = (int) $inn;
        $start_date = DbQuery::protectedData($start_date);
        $end_date = DbQuery::protectedData($end_date);
        $count = (int) $count;
        $price = (float) $price;
        $comment = (float) $comment;
        $is_ready = (boolean) $is_ready;
        $status_payment_id = (int) $status_payment_id;
        $status_delivery_id = (int) $status_delivery_id;
        
        if (strlen($name) < 3) return "Название компании меньше 3 символов";

        if (!$address) return "Не указан адрес";

        if (!$start_date) return "Отсуствует дата начала проекта";

        if (!$end_date) return "Отсуствует дата окончания проекта";

        if (!$price) return "Нет стоимости";

        Project::create($name, $address, $inn, $start_date, $end_date, $count, $price, $price_commission, $comment, $is_ready, $status_payment_id, $status_delivery_id);
    }
}

?>