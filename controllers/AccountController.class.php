<?php
namespace App\Controllers;

use App\Controllers\Base as cBase;
use App\Models as models;

/**
 * Created by PhpStorm.
 * User: Dmitrii Karasev
 * Date: 02.03.2022
 */
class AccountController extends cBase\Controller
{
    public $pageTitle;
    public $metaDescription;
    public $metaKeywords;
    public $pageCanonical;
    public $menuItem;
    public $pageHeading;
    public $view = 'Account';

    function __construct()
    {
        parent :: __construct();


    }

    /**
     * Возвращает личный кабинет.
     *
     * @param mixed[] $data массив url-параметров.
     * @return mixed[] возвращает данные авторизации.
     */
    function Index($data) : array
    {
        $this -> pageTitle      .= ' | Личный кабинет';
        $this -> metaDescription = 'ООО ЛАГОС Личный кабинет пользователя';
        $this -> metaKeywords    = 'личный кабинет, асфальт, бетон, дороги, строительство';
        $this -> pageCanonical   = 'https://lagoc.ru/lk';
        $this -> menuItem        = 'lk';
        $this -> pageHeading     = 'Личный кабинет пользователя';

        if ($_COOKIE['authuserid'] && $_COOKIE['authuser']) {
            $userId = $_COOKIE['authuserid'];
            return models\Account :: getAccount($userId);
        } else {
            header('Location: /login');
        }
    }

    /**
     * Вход на сайт.
     *
     * @param mixed[] $data массив url-параметров.
     */
    function Login($data) : ?string
    {
        $this -> pageTitle      .= ' | Вход на сайт';
        $this -> metaDescription = 'ООО ЛАГОС Войти на сайт';
        $this -> metaKeywords    = 'вход на сайт, асфальт, бетон, дороги, строительство';
        $this -> pageCanonical   = 'https://lagoc.ru/login';
        $this -> menuItem        = 'login';
        $this -> pageHeading     = 'Выполнить вход';

        if ($this -> isPost()) {
            $login      = isset($_POST['login']) ? filter_var(trim($_POST['login']), FILTER_SANITIZE_STRING) : false;
            $passwd     = isset($_POST['passwd']) ? filter_var(trim($_POST['passwd']), FILTER_SANITIZE_STRING) : false;
            $rememberme = isset($_POST['rememberme']) && filter_var(trim($_POST['rememberme']), FILTER_SANITIZE_STRING);

            if (mb_strlen($login) < 3 || mb_strlen($login) > 90) {
                return '<p class="text-danger">Недопустимая длина логина! Длина логина от 3 до 90 символов!</p><hr class="bhr" /><br />';
            }

            if (mb_strlen($passwd) < 3 || mb_strlen($passwd) > 20) {
                return '<p class="text-danger">Недопустимая длина пароля! Пароль должен быть от 3 до 20 символов!</p><hr class="bhr" /><br />';
            }

            if ($login && $passwd) {
                $auth = models\Account :: checkAccount($login, $passwd);

                if ($auth) {
                    models\Account :: setLoginTime($login);
                    setcookie('authuserid', (string)$auth['userid'], time() + 3600, '/');   // На один час
                    setcookie('authuser', $auth['username'], time() + 3600, '/');           // На один час
                    setcookie('authroleid', (string)$auth['roleid'], time() + 3600, '/');   // На один час

                    if($rememberme) {
                        setcookie('login', $login, time() + 3600 * 24 * 365, '/');          // На один год
                    }

                    $total = models\Cart :: getTotal($auth['userid']);
                    if ($total) setcookie('cartprodtotal', (string)$total[0]['cnt'], time() + 3600 * 24 * 365, '/'); // На один год
                    else setcookie('cartprodtotal', '', time() - 3600, '/');

                    header('Location: /lk');
                } else {
                    return '<p class="text-danger">Вы ввели неверные данные! Попробуйте еще раз!</p><hr class="bhr" /><br />';
                }
            } else {
                return '<p class="text-danger">Вы ввели неверные данные! Попробуйте еще раз!</p><hr class="bhr" /><br />';
            }
        }
        return null;
    }

    /**
     * Регистрация на сайте.
     *
     * @param mixed[] $data массив url-параметров.
     */
    function Register($data) : ?string
    {
        $this -> pageTitle      .= ' | Регистрация пользователя';
        $this -> metaDescription = 'ООО ЛАГОС Регистрация нового пользователя';
        $this -> metaKeywords    = 'личный кабинет, регистрация, асфальт, бетон, дороги, строительство';
        $this -> pageCanonical   = 'https://lagoc.ru/register';
        $this -> menuItem        = 'register';
        $this -> pageHeading     = 'Регистрация нового пользователя';

        if ($this -> isPost()) {
            $login          = isset($_POST['login']) ? filter_var(trim($_POST['login']), FILTER_SANITIZE_STRING) : false;
            $passwd         = isset($_POST['passwd']) ? filter_var(trim($_POST['passwd']), FILTER_SANITIZE_STRING) : false;
            $confirmPasswd  = isset($_POST['confirmpasswd']) ? filter_var(trim($_POST['confirmpasswd']), FILTER_SANITIZE_STRING) : false;
            $userName       = isset($_POST['username']) ? filter_var(trim($_POST['username']), FILTER_SANITIZE_STRING) : false;
            $email          = isset($_POST['useremail']) ? filter_var(trim($_POST['useremail']), FILTER_SANITIZE_STRING) : false;

            if (mb_strlen($login) < 3 || mb_strlen($login) > 90) {
                return '<p class="text-danger">Недопустимая длина логина! Длина логина от 3 до 90 символов!</p><hr class="bhr" /><br />';
            }

            if (mb_strlen($passwd) < 3 || mb_strlen($passwd) > 20) {
                return '<p class="text-danger">Недопустимая длина пароля! Пароль должен быть от 3 до 20 символов!</p><hr class="bhr" /><br />';
            }

            if (!$passwd || !$confirmPasswd || $passwd != $confirmPasswd) {
                return '<p class="text-danger">Пароли не совпадают!</p><hr class="bhr" /><br />';
            }

            if (mb_strlen($userName) < 3 || mb_strlen($userName) > 150) {
                return '<p class="text-danger">Недопустимая длина имени пользователя! Длина имени от 3 до 150 символов!</p><hr class="bhr" /><br />';
            }

            if (mb_strlen($email) < 5 || mb_strlen($email) > 150) {
                return '<p class="text-danger">Недопустимая длина e-mail пользователя! Длина e-mail от 5 до 150 символов!</p><hr class="bhr" /><br />';
            }

            if ($login && $userName && $email) {
                $passwd = password_hash($passwd,PASSWORD_ARGON2ID); // Создаем хэш из пароля

                $res = models\Account :: registerAccount($login, $passwd, $userName, $email);

                if ($res > 0) {
                    header("Location: /login");
                } else if ($res == -1) {
                    return '<p class="text-danger">Такой логин уже зарегистрирован!</p><hr class="bhr" /><br />';
                } else if ($res == -2) {
                    return '<p class="text-danger">Такой e-mail уже зарегистрирован!</p><hr class="bhr" /><br />';
                } else {
                    return '<p class="text-danger">Не удалось зарегистрировать пользователя! Попробуйте еще раз!</p><hr class="bhr" /><br />';
                }
            } else {
                return '<p class="text-danger">Вы ввели неверные данные! Попробуйте еще раз!</p><hr class="bhr" /><br />';
            }
        }
        return null;
    }

    /**
     * Изменение учетных данных.
     *
     * @param mixed[] $data массив url-параметров.
     */
    function Edit($data) : bool
    {
        // А EMAIL  - проверять и при регистрации и при изменении. несколько = нельяз, для восстановления пароля. Если несколько - куда слдать
        return false;
    }

    /**
     * Удалить аккаунт на сайте.
     *
     * @param mixed[] $data массив url-параметров.
     */
    function Remove($data)
    {
        $this -> pageTitle      .= ' | Удалить учетную запись';
        $this -> metaDescription = 'ООО ЛАГОС Удалить учетную записьт';
        $this -> metaKeywords    = 'удалить учетную запись, асфальт, бетон, дороги, строительство';
        $this -> pageCanonical   = 'https://lagoc.ru/removeuser';
        $this -> menuItem        = 'removeuser';
        $this -> pageHeading     = 'Удалить учетную запись';

        if ($_COOKIE['authuserid'] && $_COOKIE['authuser']) {
            if ($this -> isPost()) {
                $login  = isset($_POST['login']) ? filter_var(trim($_POST['login']), FILTER_SANITIZE_STRING) : false;
                $passwd = isset($_POST['passwd']) ? filter_var(trim($_POST['passwd']), FILTER_SANITIZE_STRING) : false;

                if (mb_strlen($login) < 3 || mb_strlen($login) > 90) {
                    return '<p class="text-danger">Недопустимая длина логина! Длина логина от 3 до 90 символов!</p><hr class="bhr" /><br />';
                }

                if (mb_strlen($passwd) < 3 || mb_strlen($passwd) > 20) {
                    return '<p class="text-danger">Недопустимая длина пароля! Пароль должен быть от 3 до 20 символов!</p><hr class="bhr" /><br />';
                }

                if ($login && $passwd) {
                    $auth = models\Account :: checkAccount($login, $passwd);

                    if ($auth) {
                        models\Account:: removeAccount($auth['userid']);
                        $this -> Logout();
                    } else {
                        return '<p class="text-danger">Вы ввели неверные данные! Попробуйте еще раз!</p><hr class="bhr" /><br />';
                    }
                } else {
                    return '<p class="text-danger">Вы ввели неверные данные! Попробуйте еще раз!</p><hr class="bhr" /><br />';
                }
            }
        } else {
            header('Location: /');
        }
    }

    /**
     * Выйти с сайта.
     */
    function Logout() : void
    {
        setcookie('authuserid', '', time() - 3600, '/');
        setcookie('authuser', '', time() - 3600, '/');
        setcookie('authroleid', '', time() - 3600, '/');
        setcookie('cartprodtotal', '', time() - 3600, '/');
        header('Location: /');
    }
}