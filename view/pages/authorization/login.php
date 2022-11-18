<?

$email = $_REQUEST['user_email'];
$password = $_REQUEST['user_password'];

$button_log = $_REQUEST['button_log'];

if (isset($button_log)) {
    $error = UserController::log($email, $password);
}

?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <? require_once './view/components/style.php'; ?>
    <title>Вход</title>
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
                        <label for="user_email">Email</label>
                    </div>
                    <div class="input-field col s12">
                        <input class="validate" id="user_password" type="password" name="user_password">
                        <label for="user_password">Пароль</label>
                    </div>
                    <div class="authorization__buttons">
                        <button class="waves-effect waves-light btn-large blue darken-1" name="button_log">
                            Войти
                        </button>
                        <a class="blue-text text-darken-1" href="registration">
                            Нет аккаунта?
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <? require_once './view/components/script.php'; ?>
</body>

</html>