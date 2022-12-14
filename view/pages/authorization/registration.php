<?

$email = $_REQUEST['user_email'];
$password = $_REQUEST['user_password'];
$FCs = $_REQUEST['user_FCs'];
$post = $_REQUEST['user_post'];
$telephone = $_REQUEST['user_telephone'];
$about = $_REQUEST['user_about'];

$button_reg = $_REQUEST['button_reg'];

if (isset($button_reg)) {
    $error = UserController::registration($email, $password, $FCs, $post, $telephone, $about);
}

?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <? require_once './view/components/style.php'; ?>
    <title>Регистрация</title>
</head>

<body>
    <div class="wrapper">
        <div class="authorization">
            <div class="container">
                <form class="col s12" method="POST">
                    <p class="red-text text-darken-1">
                        <?= $error ?>
                    </p>
                    <div class="input-field col s12">
                        <input class="validate" id="user_email" type="email" name="user_email">
                        <label for="user_email">Email*</label>
                    </div>
                    <div class="input-field col s12">
                        <input class="validate" id="user_password" type="password" name="user_password">
                        <label for="user_password">Пароль*</label>
                    </div>
                    <p>
                        Контактная информация
                    </p>
                    <div class="input-field col s12">
                        <input class="validate" id="user_FCs" type="text" name="user_FCs">
                        <label for="user_FCs">ФИО</label>
                    </div>
                    <div class="input-field col s12">
                        <input class="validate" id="user_post" type="text" name="user_post">
                        <label for="user_post">Должность</label>
                    </div>
                    <div class="input-field col s12">
                        <input class="validate" id="user_telephone" type="tel" name="user_telephone">
                        <label for="user_telephone">Телефон</label>
                    </div>
                    <div class="input-field col s12">
                        <textarea id="user_about" class="materialize-textarea" name="user_about"></textarea>
                        <label for="user_about">О себе</label>
                    </div>
                    <div class="authorization__bottom">
                        <strong class="grey-text text-darken-2">
                            * - обязательное поле
                        </strong>
                        <div class="authorization__buttons">
                            <button class="waves-effect waves-light btn-large blue darken-1" name="button_reg">
                                Зарегистрироваться
                            </button>
                            <a class="blue-text text-darken-1" href="login">
                                Уже есть аккаунт?
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <? require_once './view/components/script.php'; ?>
</body>

</html>