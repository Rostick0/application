<?

class AuthorizationController {
    public static function create($token, $user_id) {
        $info = $_SERVER['HTTP_USER_AGENT'];
        $ip = $_SERVER['REMOTE_ADDR'];

        Authorization::create($token, $info, $ip, $user_id);
        AuthorizationController::setCookie($token);
    }

    public static function setCookie($token) {
        setcookie('session_token', $token, time() + 60*60*24*30, '/');
    }

    public static function check($token) {
        $data = Authorization::getLastToken($token)->fetch_assoc();

        if (!$data) return;

        $user_id = $data['user_id'];

        $user = DbQuery::get('user', 'user_id', $user_id)->fetch_assoc();

        if (!$user) return;

        SessionUser::create($user);
    }
}

if (!SessionUser::check() && $_COOKIE['session_token']) AuthorizationController::check($_COOKIE['session_token']);

?>