<?

$page = $_GET['page'] < 1 ? $_GET['page'] = 1 : $_GET['page'];
$page_ceil = ceil($page / 10) * 10 - 9;

$project_count = DbQuery::get('project')->num_rows;
$page_count = ceil($project_count / 20);

ProjectController::get(20, $page);

var_dump($project_count);

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

            </div>
        </div>
        <ul class="pagination">
            <!-- <li class="disabled">
                <a href="#!">
                    <i class="material-icons">
                        chevron_left
                    </i>
                </a>
            </li> -->
            <? var_dump($page) ?>
            <? for ($i = $page_ceil; $i < $page_ceil + 10; $i++) : ?>
                <li class="<?= $i == $page ? 'active blue darken-1' : 'waves-effect' ?>">
                    <a href="?offset=0">
                        <?= $i ?>
                    </a>
                </li>
            <? endfor; ?>
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
                    <i class="material-icons">
                        chevron_right
                    </i>
                </a>
            </li>
        </ul>
    </div>
    <? require_once './view/components/script.php'; ?>
</body>

</html>