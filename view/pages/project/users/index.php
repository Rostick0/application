<?

$project_id = (int) $_GET['project_id'];

$page = (int) $_GET['page'];
$page = $page ? $page : 1;
$page = $_GET['page'] < 1 ? $_GET['page'] = 1 : $_GET['page'];

$page_offset = ($page - 1) * 20;
$page_ceil = ceil($page / 10) * 10 - 9;

$project_count = DbQuery::get('project')->num_rows;
$page_count = ceil($project_count / 20);

$user_search = DbQuery::protectedData($_REQUEST['user_search']);
$user_email = $_REQUEST['user_email'];

if ($user_email) {
    $user_list = UserController::search($user_email, 20, $page_offset);
} else {
    $user_list = DbQuery::getDesc('user', 'user_id', 20, $page_offset);
}

?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <? require_once './view/components/style.php'; ?>
    <title>Поиск людей</title>
</head>

<body>
    <div class="wrapper">
        <div class="project users">
            <header class="header">
                <? require_once './view/components/header_navigation.php'; ?>
            </header>
            <div class="container">
                <form class="users__form" method="GET">
                    <div class="users__input input-field">
                        <input class="validate" id="user_email" type="text" name="user_email">
                        <label for="user_email">Поиск по почте</label>
                    </div>
                    <button class="btn waves-effect waves-light blue darken-1" type="submit" >
                        <span>
                            Поиск
                        </span>
                        <i class="material-icons right">send</i>
                    </button>
                </form>
                <? foreach ($user_list as $user) : ?>
                    <div class="col s12 m7">
                        <div class="card">
                            <div class="card-content">
                                <div class="card-content__top">
                                    <h2 class="card-content__title">
                                        <?= $user['email'] ?>
                                    </h2>
                                </div>
                            </div>
                            <div class="card-action">
                                <a href="/project/users/add?id=<?= $user['user_id'] ?>&project_id=<?= $project_id ?>">
                                    Изменить роль
                                </a>
                            </div>
                        </div>
                    </div>
                <? endforeach; ?>
                <?
                $page;
                $page_ceil;

                $project_count;
                $page_count;
                $project_query_add = "&project_id=$project_id";
                require_once './view/components/pagination.php';
                ?>
            </div>
        </div>
    </div>
    <? require_once './view/components/script.php'; ?>
</body>

</html>