<?

$id = (int) $_GET['id'];

$project = DbQuery::get('project', 'project_id', $id)->fetch_assoc();
$status_delivery = DbQuery::parse('status_delivery', 'status_delivery_id', $project['status_delivery_id']);
$status_payment = DbQuery::parse('status_payment', 'status_payment_id', $project['status_payment_id']);

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
                <div class="col s12 project__form" method="POST">
                    <? if ($error) : ?>
                        <p class="project__form_error red-text text-darken-1">
                            <?= $error ?>
                        </p>
                    <? endif; ?>
                    <div class="input-field col s12">
                        <strong for="project_name">
                            Название
                        </strong>
                        <p>
                            <?= $project['name'] ?>
                        </p>
                    </div>
                    <div class="input-field col s12">
                        <strong for="project_name">
                            Адрес
                        </strong>
                        <p>
                            <?= $project['address'] ?>
                        </p>
                    </div>
                    <div class="input-field col s12">
                        <strong for="project_name">
                            ИНН
                        </strong>
                        <p>
                            <?= $project['inn'] ?>
                        </p>
                    </div>
                    <div class="input-field col s12">
                        <strong for="project_name">
                            Количество товара
                        </strong>
                        <p>
                            <?= HtmlDom::checkData($project['count']) ?>
                        </p>
                    </div>
                    <div class="input-field col s12">
                        <strong for="project_name">
                            Количество брака
                        </strong>
                        <p>
                            <?= HtmlDom::checkData($project['count_defective']) ?>
                        </p>
                    </div>
                    <div class="project__dates">
                        <div class="input-field col s12">
                            <strong for="project_name">
                                Дата начала
                            </strong>
                            <p>
                                <?= HtmlDom::checkData($project['start_date']) ?>
                            </p>
                        </div>
                        <div class="input-field col s12">
                            <strong for="project_name">
                                Дата окончания
                            </strong>
                            <p>
                                <?= HtmlDom::checkData($project['end_date']) ?>
                            </p>
                        </div>
                    </div>
                    <div class="input-field col s12">
                        <strong for="project_name">
                            Цена
                        </strong>
                        <p>
                            <?= HtmlDom::checkData($project['price']) ?>
                        </p>
                    </div>
                    <div class="input-field col s12">
                        <strong for="project_name">
                            Цена с комиссей
                        </strong>
                        <p>
                            <?= HtmlDom::checkData($project['price_commission']) ?>
                        </p>
                    </div>
                    <div class="input-field col s12">
                        <strong for="project_name">
                            Комментарий
                        </strong>
                        <p>
                            <?= HtmlDom::checkData($project['comment']) ?>
                        </p>
                    </div>
                    <div class="input-field col s12">
                        <strong for="project_name">
                            Замечания
                        </strong>
                        <p>
                            <?= HtmlDom::checkData($project['complaint']) ?>
                        </p>
                    </div>
                    <div class="input-field col s12">
                        <strong for="project_name">
                            Статус доставки
                        </strong>
                        <p>
                            <?= HtmlDom::checkData($status_delivery) ?>
                        </p>
                    </div>
                    <div class="input-field col s12">
                        <strong for="project_name">
                            Статус оплаты
                        </strong>
                        <p>
                            <?= HtmlDom::checkData($status_payment) ?>
                        </p>
                    </div>
                    <div class="project__button project__button_edit">
                        <a class="waves-effect waves-light btn-large blue darken-1" href="/project/edit?id=<?= $project['project_id'] ?>">
                            Изменить
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <? require_once './view/components/script.php'; ?>
</body>

</html>