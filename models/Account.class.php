<?php
    class Account extends Model
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

            self::$properties['email'] = [
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

        public static function getAccount($userId) {
            $sql = 'SELECT u.userid, u.username, u.email, u.login, u.lastlogintime, r.roleid, r.rolename
                    FROM users u INNER JOIN userroles ur USING(userid)
                                 INNER JOIN roles r USING(roleid)
                    WHERE u.userid=:userid
                    ORDER BY r.roleid';
            $auth = DBContext :: getInstance() -> Select($sql, ['userid' => $userId]);

            if ($auth && count($auth) > 0) {
                return $auth;
            }
            return null;
        }

        public static function checkAccount($login, $passwd)
        {
            $sql = 'SELECT u.userid, u.username, u.passwd, r.roleid
                    FROM users u INNER JOIN userroles ur USING(userid)
                                 INNER JOIN roles r USING(roleid)
                    WHERE u.login=:login
                    ORDER BY r.roleid';
            $auth = DBContext :: getInstance() -> Select($sql, ['login' => $login]);

            if ($auth && count($auth) > 0) {
                if (password_verify($passwd, $auth[0]['passwd'])) {
                    return ['userid' => $auth[0]['userid'], 'username' => $auth[0]['username'], 'roleid' => $auth[0]['roleid']];
                }
            }
            return false;
        }

        public static function setLoginTime($login) : void
        {
            DBContext :: getInstance() -> Query('UPDATE users SET lastlogintime = now() WHERE login = :login',['login' => $login]);
        }

        public static function removeAccount($userId) {
            DBContext :: getInstance() -> Query('DELETE FROM users WHERE userid = :userid',['userid' => $userId]);
        }

        public static function checkLogin($login) : bool
        {
            $checkLogin = DBContext :: getInstance() -> Select('SELECT 1 yes FROM users WHERE login=:login', ['login' => $login]);

            if ($checkLogin && count($checkLogin) > 0) {
                return true;
            }
            return false;
        }

        public static function checkEmail($email) : bool
        {
            $checkEmail = DBContext :: getInstance() -> Select('SELECT 1 yes FROM users WHERE email=:email', ['email' => $email]);

            if ($checkEmail && count($checkEmail) > 0) {
                return true;
            }
            return false;
        }

        public static function registerAccount($login, $passwd, $userName, $email)
        {
            $ifLogin = self :: checkLogin($login);
            $ifEmail = self :: checkEmail($email);

            if ($ifLogin) return -1;
            if ($ifEmail) return -2;

            return DBContext :: getInstance() -> Query('INSERT INTO users (username, email, login, passwd) VALUES(:username, :email, :login, :passwd)',
                ['username' => $userName, 'email' => $email, 'login' => $login, 'passwd' => $passwd]);
        }
    }