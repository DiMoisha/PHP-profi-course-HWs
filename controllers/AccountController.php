<?php
    class AccountController extends Controller
    {
        public $view = 'Account';
        public $title;
        public $heading;

        function __construct()
        {
            parent :: __construct();
        }

        function index($data){
            $this -> title .= ' | Личный кабинет';
            $this -> heading = 'Личный кабинет пользователя';
            if($_COOKIE['authuserid'] && $_COOKIE['authuser']) {
                return '<p><b>Привет <font color="red">'.$_COOKIE['authuser'].'</font>! Это ваш Личный кабинет!</b></p>';
            } else {
                header("Location: /public/?path=account/login");
            }
        }

        function register()
        {
            $this -> title .= ' | Личный кабинет';
            $this -> heading = 'Регистрация нового пользователя';

            if($this->isPost()) {
                $username = isset($_POST['username']) ? $_POST['username'] : false;
                $login = isset($_POST['login']) ? $_POST['login'] : false;
                $passwd = isset($_POST['passwd']) ? md5($_POST['passwd']."abzlagoc") : false; // Создаем хэш из пароля

                if ($username && $login && $passwd) {
                    $res = AccountModel :: registerAccount($username, $login, $passwd);
                    if ($res > 0) {
                        header("Location: /public/?path=account/login");
                    } else if ($res == -1) {
                        return '<h2>Регистрация нового пользователя: такой логин уже есть!</h2><hr>';
                    } else {
                        return '<h2>Регистрация нового пользователя: попробуйте еще раз!</h2><hr>';
                    }
                }
            }
            return '<h2>Регистрация нового пользователя</h2><hr>';
        }

        function login()
        {
            $this -> title .= ' | Личный кабинет';
            $this -> heading = 'Войти в личный кабинет';

            if($this -> isPost()) {
                $login = isset($_POST['login']) ? $_POST['login'] : false;
                $passwd = isset($_POST['passwd']) ? md5($_POST['passwd']."abzlagoc") : false;

                if ($login && $passwd) {
                    $auth = AccountModel :: checkAccount($login, $passwd);
                    if ($auth) {
                        setcookie('authuserid', (string)$auth[0]['userid'], time() + 3600, "/");
                        setcookie('authuser', $auth[0]['username'], time() + 3600, "/");
                        header("Location: /public/?path=account");
                    }
                }
            }
            return '<h2>Выполнить вход</h2><p ></p><hr>';
        }

        function logout()
        {
            setcookie('authuserid', "", time() - 3600, "/");
            setcookie('authuser', "", time() - 3600, "/");
            header("Location: /public");
        }
    }