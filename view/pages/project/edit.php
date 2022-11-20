<?

$project_id = (int) $_GET['id'];

$project = DbQuery::get('project', 'project_id', $project_id)->fetch_assoc();

if (!$project) {
    header('Location: /project/create');
}

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

$my_access = ProjectAccessController::getMy($project_id)->fetch_assoc();
$my_acces_name = json_decode($my_access['name'], true);

if (isset($button_create)) {
    // $error = ProjectController::create($name, $address, $inn, $start_date, $end_date, $count, $count_defective, $price, $price_commission, $comment, $complaint, $is_ready, $status_payment_id, $status_delivery_id);
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
                        <? if (array_search('name', $my_acces_name) !== false) : ?>
                            <input class="validate" id="project_name" type="text" name="project_name" value="<?= $project['name'] ?>">
                            <label for="project_name">Название*</label>
                        <? else : ?>
                            <strong>
                                Название
                            </strong>
                            <p>
                                <?= $project['name'] ?>
                            </p>
                        <? endif; ?>
                    </div>
                    <div class="input-field col s12">
                        <? if (array_search('address', $my_acces_name) !== false) : ?>
                            <input class="validate" id="project_address" type="text" name="project_address" value="<?= $project['address'] ?>">
                            <label for="project_address">
                                Адрес*
                            </label>
                        <? else : ?>
                            <strong>
                                Адрес
                            </strong>
                            <p>
                                <?= $project['address'] ?>
                            </p>
                        <? endif; ?>
                    </div>
                    <div class="input-field col s12">
                        <? if (array_search('inn', $my_acces_name) !== false) : ?>
                            <input class="validate" id="project_inn" type="number" name="project_inn" value="<?= $project['inn'] ?>">
                            <label for="project_inn">ИНН*</label>
                        <? else : ?>
                            <strong>
                                ИНН
                            </strong>
                            <p>
                                <?= $project['inn'] ?>
                            </p>
                        <? endif; ?>
                    </div>
                    <div class="input-field col s12">
                        <? if (array_search('count', $my_acces_name) !== false) : ?>
                            <input class="validate" id="project_count" type="number" name="project_count" value="<?= $project['count'] ?>">
                            <label for="project_count">Количество товара*</label>
                        <? else : ?>
                            <strong>
                                Количество товара
                            </strong>
                            <p>
                                <?= $project['count'] ?>
                            </p>
                        <? endif; ?>
                    </div>
                    <div class="input-field col s12">
                        <? if (array_search('count_defective', $my_acces_name) !== false) : ?>
                            <input class="validate" id="project_count_defective" type="number" name="project_count_defective" value="<?= $project['count_defective'] ?>">
                            <label for="project_count_defective">Количество брака*</label>
                        <? else : ?>
                            <strong>
                                Количество брака
                            </strong>
                            <p>
                                <?= $project['count_defective'] ?>
                            </p>
                        <? endif; ?>
                    </div>
                    <div class="project__dates">
                        <div class="input-field col s12">
                            <? if (array_search('start_date', $my_acces_name) !== false) : ?>
                                <input class="validate datepicker" id="project_start_date" type="text" name="project_start_date" readonly value="<?= $project['start_date'] ?>">
                                <label for="project_start_date">Дата начала*</label>
                            <? else : ?>
                                <strong>
                                    Дата начала
                                </strong>
                                <p>
                                    <?= $project['start_date'] ?>
                                </p>
                            <? endif; ?>
                        </div>
                        <div class="input-field col s12">
                            <? if (array_search('end_date', $my_acces_name) !== false) : ?>
                                <input class="validate datepicker" id="project_end_date" type="text" name="project_end_date" readonly value="<?= $project['end_date'] ?>">
                                <label for="project_end_date">Дата окончания*</label>
                            <? else : ?>
                                <strong>
                                    Дата окончания
                                </strong>
                                <p>
                                    <?= $project['end_date'] ?>
                                </p>
                            <? endif; ?>
                        </div>
                    </div>
                    <div class="input-field col s12">
                        <? if (array_search('price', $my_acces_name) !== false) : ?>
                            <input class="validate" id="project_price" type="number" name="project_price" value="<?= $project['price'] ?>">
                            <label for="project_price">Цена*</label>
                        <? else : ?>
                            <strong>
                                Цена
                            </strong>
                            <p>
                                <?= $project['price'] ?>
                            </p>
                        <? endif; ?>
                    </div>
                    <div class="input-field col s12">
                        <? if (array_search('price_commission', $my_acces_name) !== false) : ?>
                            <input class="validate" id="project_price_commission" type="number" name="project_price_commission" value="<?= $project['price_commission'] ?>">
                            <label for="project_price_commission">Цена с комиссей*</label>
                        <? else : ?>
                            <strong>
                                Цена с комиссей
                            </strong>
                            <p>
                                <?= $project['price_commission'] ?>
                            </p>
                        <? endif; ?>
                    </div>
                    <div class="input-field col s12">
                        <? if (array_search('comment', $my_acces_name) !== false) : ?>
                            <textarea class="materialize-textarea" id="project_comment" name="project_comment"><?= $project['comment'] ?></textarea>
                            <label for="project_comment">Комментарий</label>
                        <? else : ?>
                            <strong>
                                Комментарий
                            </strong>
                            <p>
                                <?= $project['comment'] ?>
                            </p>
                        <? endif; ?>
                    </div>
                    <div class="input-field col s12">
                        <? if (array_search('complaint', $my_acces_name) !== false) : ?>
                            <textarea class="materialize-textarea" id="project_complaint" name="project_complaint"><?= $project['complaint'] ?></textarea>
                            <label for="project_complaint">
                                Замечания
                            </label>
                        <? else : ?>
                            <strong>
                                Замечания
                            </strong>
                            <p>
                                <?= $project['complaint'] ?>
                            </p>
                        <? endif; ?>
                    </div>
                    <div class="input-field col s12">
                        <? if (array_search('status_delivery', $my_acces_name) !== false) : ?>
                            <select name="status_delivery_id">
                                <? foreach ($status_delivery as $value) : ?>
                                    <option value="<?= $value['status_delivery_id'] ?>" <?= $project['status_delivery_id'] == $value['status_delivery_id'] ? 'selected' : '' ?>><?= $value['name'] ?></option>
                                <? endforeach; ?>
                            </select>
                            <label>
                                Статус доставки
                            </label>
                        <? else : ?>
                            <strong>
                                Статус доставки
                            </strong>
                            <p>
                                <?= DbQuery::parse('status_delivery', 'status_delivery_id', $project['status_delivery_id']) ?>
                            </p>
                        <? endif; ?>
                    </div>
                    <div class="input-field col s12">
                        <? if (array_search('status_delivery', $my_acces_name) !== false) : ?>
                            <select name="status_payment_id">
                                <? foreach ($status_payment as $value) : ?>
                                    <option value="<?= $value['status_payment_id'] ?>" <?= $project['status_payment_id'] == $value['status_payment_id'] ? 'selected' : '' ?>><?= $value['name'] ?></option>
                                <? endforeach; ?>
                            </select>
                            <label>
                                Статус оплаты
                            </label>
                        <? else : ?>
                            <strong>
                                Статус оплаты
                            </strong>
                            <p>
                                <?= DbQuery::parse('status_payment', 'status_payment_id', $project['status_payment_id']) ?>
                            </p>
                        <? endif; ?>
                    </div>
                    <div class="project__button project__button_edit">
                        <button class="waves-effect waves-light btn-large blue darken-1" name="button_create">
                            Изменить
                        </button>
                        <label class="project__is-ready">
                            <input type="checkbox" class="filled-in" />
                            <span class="project__is-ready_text">
                                <span class="project__is-ready_text">
                                    Заявка готова?
                                </span>
                            </span>
                        </label>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <? require_once './view/components/script.php'; ?>
</body>

</html>