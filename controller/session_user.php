<?

class SessionUser {
    public static function create($user) {
        $_SESSION['user'] = $user;
    }

    public static function delete() {
        $_SESSION['user'] = null;
    }

    public static function check() {
        return !empty($_SESSION['user']['user_id']);
    }
}

?>