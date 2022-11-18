<?

$name = $_REQUEST['user_name'];
$email = $_REQUEST['user_email'];
$password = $_REQUEST['user_password'];
$about = $_REQUEST['user_about'];

$button_reg = $_REQUEST['button_reg'];

if (isset($button_reg)) {
    $error = UserController::registration($name, $email, $password, $about);
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
                        <input class="validate" id="user_name" type="text" name="user_name">
                        <label for="user_name">Ваше имя*</label>
                    </div>
                    <div class="input-field col s12">
                        <input class="validate" id="user_email" type="email" name="user_email">
                        <label for="user_email">Email*</label>
                    </div>
                    <div class="input-field col s12">
                        <input class="validate" id="user_password" type="password" name="user_password">
                        <label for="user_password">Пароль*</label>
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