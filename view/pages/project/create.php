<?

$users = DbQuery::get('user');
$zmo = DbQuery::get('zmo');
$status_delivery = DbQuery::get('status_delivery');
$status_payment = DbQuery::get('status_payment');
$status_exploitation = DbQuery::get('status_exploitation');

$is_made_order = $_REQUEST['project_is_made_order'];
$documents = $_REQUEST['project_documents'];
$document_scan = $_REQUEST['project_document_scan'];
$name = $_REQUEST['project_name'];
$address = NULL;
$inn = $_REQUEST['project_inn'];
$contract = $_REQUEST['project_contract'];
$zmo_id = $_REQUEST['project_zmo'];
$start_date = $_REQUEST['project_start_date'];
$end_date = $_REQUEST['project_end_date'];
$delivery_date = $_REQUEST['project_delivery_date'];
$comment = $_REQUEST['project_comment'];
$complaint = $_REQUEST['project_complaint'];

$button_create = $_REQUEST['button_create'];

$text = [];
$products = [
    $_REQUEST['product_name'],
    $_REQUEST['product_track_number'],
    $_REQUEST['product_warehouse'],
    $_REQUEST['product_address_from'],
    $_REQUEST['product_address_to'],
    $_REQUEST['product_count'],
    $_REQUEST['product_unit_measurement'],
    $_REQUEST['product_price'],
    $_REQUEST['product_amount'],
    $_REQUEST['product_purchase_price'],
    $_REQUEST['product_purchase_amount'],
    $_REQUEST['product_status_delivery'],
    $_REQUEST['product_status_payment'],
    $_FILES['product_document'],
    $_REQUEST['product_link'],
    $_REQUEST['product_shipping_cost'],
    $_REQUEST['product_status_exploitation']
];

if (isset($button_create)) {
    $error = ProjectController::create($name, $contract, $address, $inn, $start_date, $end_date, $delivery_date, $comment, $complaint, $zmo_id, $is_made_order, $document_scan, $documents, 0, $products);
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
                <div class="project__container">
                    <? if ($error) : ?>
                        <p class="project__form_error red-text text-darken-1">
                            <?= $error ?>
                        </p>
                    <? endif; ?>
                    <form class="col s12 project__form" method="POST" enctype="multipart/form-data">
                        <div class="project__flex">
                            <label class="project__is-ready">
                                <input type="checkbox" class="filled-in" name="project_is_made_order">
                                <span class="project__is-ready_text">
                                    <span class="project__is-ready_text">
                                        Заказ сделан?
                                    </span>
                                </span>
                            </label>
                            <label class="project__is-ready">
                                <input type="checkbox" class="filled-in" name="project_documents">
                                <span class="project__is-ready_text">
                                    <span class="project__is-ready_text">
                                        Документы готовы?
                                    </span>
                                </span>
                            </label>
                        </div>
                        <div class="project__flex">
                            <label class="project__is-ready">
                                <input type="checkbox" class="filled-in" name="project_document_scan">
                                <span class="project__is-ready_text">
                                    <span class="project__is-ready_text">
                                        Скан документов готов?
                                    </span>
                                </span>
                            </label>
                        </div>
                        <div class="project__flex">
                            <div class="input-field col s12">
                                <input class="validate" id="project_name" type="text" name="project_name">
                                <label for="project_name">Название*</label>
                            </div>
                            <div class="input-field col s12">
                                <input class="validate" id="project_inn" type="number" name="project_inn">
                                <label for="project_inn">ИНН*</label>
                            </div>
                            <div class="input-field col s12">
                                <input class="validate" id="project_contract" type="number" name="project_contract">
                                <label for="project_contract">Номер договора</label>
                            </div>
                        </div>
                        <div class="project__flex">
                            <div class="input-field col s12">
                                <select name="project_zmo">
                                    <? foreach ($zmo as $value) : ?>
                                        <option value="<?= $value['zmo_id'] ?>"><?= $value['name'] ?></option>
                                    <? endforeach; ?>
                                </select>
                                <label>ЗМО</label>
                            </div>
                        </div>
                        <div class="project__flex">
                            <div class="input-field col s12">
                                <input class="validate datepicker" id="project_start_date" type="text" name="project_start_date" readonly>
                                <label for="project_start_date">Дата начала контракта*</label>
                            </div>
                            <div class="input-field col s12">
                                <input class="validate datepicker" id="project_end_date" type="text" name="project_end_date" readonly>
                                <label for="project_end_date">Дата окончания контракта*</label>
                            </div>
                            <div class="input-field col s12">
                                <input class="validate datepicker" id="project_delivery_date" type="text" name="project_delivery_date" readonly>
                                <label for="project_delivery_date">Дата доставки*</label>
                            </div>
                        </div>
                        <div class="input-field col s12">
                            <textarea class="materialize-textarea" id="project_comment" name="project_comment"></textarea>
                            <label for="project_comment">Комментарий</label>
                        </div>
                        <div class="input-field col s12">
                            <textarea class="materialize-textarea" id="project_complaint" name="project_complaint"></textarea>
                            <label for="project_complaint">Замечания</label>
                        </div>
                        <div class="project__button project__button_add">
                            <button class="waves-effect waves-light btn-large blue darken-1 product_add">
                                Добавить товар
                            </button>
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
    </div>
    <? require_once './view/components/script.php'; ?>
</body>

</html>