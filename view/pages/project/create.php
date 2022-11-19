<?

$status_delivery = DbQuery::get('status_delivery');
$status_payment = DbQuery::get('status_payment');

$name = $_REQUEST['project_name'];
$address = $_REQUEST['project_address'];
$inn = $_REQUEST['project_inn'];
$count = $_REQUEST['project_count'];
$count_defective = $_REQUEST['project_count_defective'];
$start_date = $_REQUEST['project_start_date'];
$end_date = $_REQUEST['project_end_date'];
$price = $_REQUEST['project_price'];
$price_commission = $_REQUEST['project_price_commission'];
$comment = $_REQUEST['project_comment'];
$complaint = $_REQUEST['project_complaint'];
$status_payment_id = $_REQUEST['status_payment_id'];
$status_delivery_id = $_REQUEST['status_delivery_id'];

$button_create = $_REQUEST['button_create'];

if (isset($button_create)) {
    $error = ProjectController::create($name, $address, $inn, $start_date, $end_date, $count, $count_defective, $price, $price_commission, $comment, $complaint, $is_ready, $status_payment_id, $status_delivery_id);
}

?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <? require_once './view/components/style.php'; ?>
    <title>Создание проекта</title>
</head>

<body>
    <div class="wrapper">
        <div class="project">
            <header class="header">
                <? require_once './view/components/header_navigation.php'; ?>
            </header>
            <div class="container">
                <form class="col s12 project__form" method="POST">
                    <? if ($error) : ?>
                        <p class="project__form_error red-text text-darken-1">
                            <?= $error ?>
                        </p>
                    <? endif; ?>
                    <div class="input-field col s12">
                        <input class="validate" id="project_name" type="text" name="project_name">
                        <label for="project_name">Название*</label>
                    </div>
                    <div class="input-field col s12">
                        <input class="validate" id="project_address" type="text" name="project_address">
                        <label for="project_address">Адрес*</label>
                    </div>
                    <div class="input-field col s12">
                        <input class="validate" id="project_inn" type="number" name="project_inn">
                        <label for="project_inn">ИНН*</label>
                    </div>
                    <div class="input-field col s12">
                        <input class="validate" id="project_count" type="number" name="project_count">
                        <label for="project_count">Количество товара*</label>
                    </div>
                    <div class="input-field col s12">
                        <input class="validate" id="project_count_defective" type="number" name="project_count_defective">
                        <label for="project_count_defective">Количество брака*</label>
                    </div>
                    <div class="project__dates">
                        <div class="input-field col s12">
                            <input class="validate datepicker" id="project_start_date" type="text" name="project_start_date" readonly>
                            <label for="project_start_date">Дата начала*</label>
                        </div>
                        <div class="input-field col s12">
                            <input class="validate datepicker" id="project_end_date" type="text" name="project_end_date" readonly>
                            <label for="project_end_date">Дата окончания*</label>
                        </div>
                    </div>
                    <div class="input-field col s12">
                        <input class="validate" id="project_price" type="number" name="project_price">
                        <label for="project_price">Цена*</label>
                    </div>
                    <div class="input-field col s12">
                        <input class="validate" id="project_price_commission" type="number" name="project_price_commission">
                        <label for="project_price_commission">Цена с комиссей*</label>
                    </div>
                    <div class="input-field col s12">
                        <textarea class="materialize-textarea" id="project_comment" name="project_comment"></textarea>
                        <label for="project_comment">Комментарий</label>
                    </div>
                    <div class="input-field col s12">
                        <textarea class="materialize-textarea" id="project_complaint" name="project_complaint"></textarea>
                        <label for="project_complaint">Замечания</label>
                    </div>
                    <div class="input-field col s12">
                        <select name="status_delivery_id">
                            <? foreach ($status_delivery as $value) : ?>
                                <option value="<?= $value['status_delivery_id'] ?>"><?= $value['name'] ?></option>
                            <? endforeach; ?>
                        </select>
                        <label>Статус доставки</label>
                    </div>
                    <div class="input-field col s12">
                        <select name="status_payment_id">
                            <? foreach ($status_payment as $value) : ?>
                                <option value="<?= $value['status_payment_id'] ?>"><?= $value['name'] ?></option>
                            <? endforeach; ?>
                        </select>
                        <label>Статус оплаты</label>
                    </div>
                    <div class="project__button">
                        <button class="waves-effect waves-light btn-large blue darken-1" name="button_create">
                            Создать
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <? require_once './view/components/script.php'; ?>
</body>

</html>