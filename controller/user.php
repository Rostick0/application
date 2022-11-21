<?

class UserController {
    public static function registration($name, $email, $password, $about) {
        $name = DbQuery::protectedData($name);
        $email =  DbQuery::protectedData($email);
        $password =  DbQuery::protectedData($password);
        $about =  DbQuery::protectedData($about);

        if (DbQuery::get('user', 'email', $email)->num_rows > 0) return "Данный аккаунт уже существует";

        if (!$name) return "Отсуствует имя";

        if (mb_strlen($email) < 5) return "Пароль почта 5 символов";

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) return "Неправильная почта";

        if (mb_strlen($password) < 8) return "Пароль меньше 8 символов";

        $password = password_hash($password, PASSWORD_DEFAULT);

        $user_id = User::create($name, $email, $password, $about);

        if (!$user_id) return "Ошибка при создании";

        $token = md5(random_int(1000, 9999) . time());

        AuthorizationController::create($token, $user_id);

        $user = DbQuery::get('user', 'user_id', $user_id)->fetch_assoc();

        SessionUser::create($user);
        header('Location: /');
    }

    public static function log($email, $password) {
        $email =  DbQuery::protectedData($email);
        $password =  DbQuery::protectedData($password);

        if (!$email || !$password) return "Введите данные";

        $user = DbQuery::get('user', 'email', $email)->fetch_assoc();
        $password_hash = null;

        if (!$user) return 'Данного пользователя не существует';

        $password_hash = $user['password'];

        if (!password_verify($password, $password_hash)) return "Неправильный пароль";

        $token = md5(random_int(1000, 9999) . time());

        AuthorizationController::create($token, $user['user_id']);

        SessionUser::create($user);
        header('Location: /');
    }

    public static function search($email, $limit = 20, $offset = 0) {
        $email = DbQuery::protectedData($email);
        $limit = (int) $limit;
        $offset = (int) $offset;

        return User::search($email, $limit, $offset);
    }
}

?>