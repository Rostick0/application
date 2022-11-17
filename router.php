<?

$path_page = './view/pages';

switch ($URI) {
    case '/api':
        $path_page = './api/index.php';
        break;
    case '/registration':
        $path_page .= '/authorization/registration.php';
        break;
    case '/login':
        $path_page .= '/authorization/login.php';
        break;
    case '/project':
        $path_page .= '/project/create.php';
        break;
    case '/project/edit':
        $path_page .= '/project/edit.php';
        break;
    case '/project/create':
        $path_page .= '/project/create.php';
        break;
    case '/profile':
        $path_page .= '/profile/profile.php';
        break;
    case '/admin':
        $path_page .= '/admin/index.php';
        break;
    default:
        $path_page .= '/index.php';
}

if (!file_exists($path_page)) {
    $path_page = './view/pages/index.php';
}

require_once $path_page;

?>