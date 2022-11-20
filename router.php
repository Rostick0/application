<?

$path_page = './view/pages';

switch ($URI) {
    case '/api':
        $path_page = './api/index.php';
        break;
    case '/':
        $path_page .= '/index.php';
        break;
    case '/registration':
        $path_page .= '/authorization/registration.php';
        break;
    case '/login':
        $path_page .= '/authorization/login.php';
        break;
    case '/project':
        $path_page .= '/project/index.php';
        break;
    case '/project/edit':
        $path_page .= '/project/edit.php';
        break;
    case '/project/create':
        $path_page .= '/project/create.php';
        break;
    case '/project/my':
        $path_page .= '/project/my.php';
        break;
    case '/history':
        $path_page .= '/history/index.php';
        break;
    // case '/profile':
    //     $path_page .= '/profile/profile.php';
    //     break;
    // case '/admin':
    //     $path_page .= '/admin/index.php';
        break;
    default:
        $path_page .= '/404.php';
}

$no_auth_uri = [
    '/login',
    '/registration'
];

if (SessionUser::check()) {
    $redirect = false;

    foreach ($no_auth_uri as $uri) {
        if ($uri !== $URI) continue;

        $redirect = true;
        break;
    }

    if ($redirect) header('Location: /');
} else {
    $redirect = true;

    foreach ($no_auth_uri as $uri) {
        if ($uri !== $URI) continue;

        $redirect = false;
        break;
    }

    if ($redirect) header('Location: /login');
}

if (!file_exists($path_page)) {
    $path_page = './view/pages/error/404.php';
}

require_once $path_page;

?>