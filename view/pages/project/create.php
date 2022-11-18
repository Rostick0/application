<?

$status_delivery = DbQuery::get('status_delivery');
$status_payment = DbQuery::get('status_payment');

// $name = $_REQUEST['user_name'];
// $email = $_REQUEST['user_email'];
// $password = $_REQUEST['user_password'];
// $about = $_REQUEST['user_about'];

// $button_reg = $_REQUEST['button_reg'];

// if (isset($button_reg)) {
//     $error = UserController::registration($name, $email, $password, $about);
// }

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
                    <div>
                        <div class="input-field col s12">
                            <input class="validate datepicker" id="project_start_date" type="text" name="project_start_date">
                            <label for="project_start_date">Дата начала*</label>
                        </div>
                        <div class="input-field col s12">
                            <input class="validate datepicker" id="project_end_date" type="text" name="project_end_date">
                            <label for="project_end_date">Дата окончания*</label>
                        </div>
                    </div>
                    <div class="input-field col s12">
                        <select>
                            <? foreach ($status_delivery as $value) : ?>
                                <option value="<?= $value['status_delivery_id'] ?>"><?= $value['name'] ?></option>
                            <? endforeach; ?>
                        </select>
                        <label>Статус доставки</label>
                    </div>
                    <div class="input-field col s12">
                        <select>
                            <? foreach ($status_payment as $value) : ?>
                                <option value="<?= $value['status_payment_id'] ?>"><?= $value['name'] ?></option>
                            <? endforeach; ?>
                        </select>
                        <label>Статус оплаты</label>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <? require_once './view/components/script.php'; ?>
</body>

</html>