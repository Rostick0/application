<?

$_SESSION['user'] = null;
setcookie('session_token', '', time());

header('Location: /');

?>