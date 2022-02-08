<?php
    class AccountModel extends Model
    {
        protected static $table = 'users';

        protected static function setProperties()
        {
            self::$properties['userId'] = [
                'type' => 'int',
                'autoincrement' => true,
                'readonly' => true,
                'unsigned' => true
            ];

            self::$properties['userName'] = [
                'type' => 'varchar',
                'size' => 150
            ];

            self::$properties['login'] = [
                'type' => 'varchar',
                'size' => 90
            ];

            self::$properties['passwd'] = [
                'type' => 'varchar',
                'size' => 250
            ];
        }

        public static function checkAccount($login, $passwd)
        {
            $auth = DBContext :: getInstance() -> Select(
                'SELECT userid, username FROM users WHERE login=:login AND passwd=:passwd',
                ['login' => $login, 'passwd' => $passwd]);

            if ($auth && count($auth) > 0) {
                return $auth;
            }

            return false;
        }

        public static function checkLogin($login)
        {
            $checkLogin = DBContext :: getInstance() -> Select('SELECT userid, username FROM users WHERE login=:login', ['login' => $login]);

            if ($checkLogin && count($checkLogin) > 0) {
                return true;
            }

            return false;
        }

        public static function registerAccount($username, $login, $passwd)
        {
            if (self :: checkLogin($login)) {
                return -1;
            } else {
                return DBContext :: getInstance() -> Query(
                    'INSERT INTO users (username, login, passwd) VALUES(:username, :login, :passwd)',
                    ['username' => $username, 'login' => $login, 'passwd' => $passwd]);
            }
        }
    }