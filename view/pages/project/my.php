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
    <title>Создание проекта</title>
</head>

<body>
    <div class="wrapper">
        <div class="project">
            <header class="header">
                <? require_once './view/components/header_navigation.php'; ?>
            </header>

            <ul class="pagination">
                <li class="disabled">
                    <a href="#!">
                        <i class="material-icons"></i>
                    </a>
                </li>
                <li class="active blue darken-1">
                    <a href="?offset=0">
                        1
                    </a>
                </li>
                <li class="waves-effect">
                    <a href="#!">
                        2
                    </a>
                </li>
                <li class="waves-effect">
                    <a href="#!">
                        3
                    </a>
                </li>
                <li class="waves-effect">
                    <a href="#!">
                        4
                    </a>
                </li>
                <li class="waves-effect">
                    <a href="#!">
                        5
                    </a>
                </li>
                <li class="waves-effect">
                    <a href="#!">
                        <i class="material-icons"></i>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <? require_once './view/components/script.php'; ?>
</body>

</html>