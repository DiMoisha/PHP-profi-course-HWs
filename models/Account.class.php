<?php
namespace App\Models;

use App\Lib as lib;
use App\Models\Abstracts as mAbstracts;

/**
 * Created by PhpStorm.
 * User: Dmitrii Karasev
 * Date: 02.03.2022
 */
class Account extends mAbstracts\Model
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

    /**
     * Возвращает информацию по конкретному аккаунту.
     *
     * @param int $userId ID пользователя.
     * @return mixed[] $auth возвращает массив учетных данных.
     */
    public static function getAccount(int $userId) : ?array
    {
        $sql = 'SELECT u.userid, u.username, u.email, u.login, u.lastlogintime, r.roleid, r.rolename
                    FROM users u INNER JOIN userroles ur USING(userid)
                                 INNER JOIN roles r USING(roleid)
                    WHERE u.userid=:userid
                    ORDER BY r.roleid';
        $auth = lib\DBContext :: getInstance() -> Select($sql, ['userid' => $userId]);

        return ($auth && count($auth) > 0) ? $auth : null;
    }

    /**
     * Проверяет логин и пароль.
     *
     * @param string $login Логин.
     * @param string $passwd Пароль.
     * @return mixed[] возвращает возвращает массив учетных данных в краткой форме если проверка успешна.
     */
    public static function checkAccount(string $login, string $passwd) : ?array
    {
        $sql = 'SELECT u.userid, u.username, u.passwd, r.roleid
                    FROM users u INNER JOIN userroles ur USING(userid)
                                 INNER JOIN roles r USING(roleid)
                    WHERE u.login=:login
                    ORDER BY r.roleid';
        $auth = lib\DBContext :: getInstance() -> Select($sql, ['login' => $login]);

        if ($auth && count($auth) > 0) {
            if (password_verify($passwd, $auth[0]['passwd'])) {
                return ['userid' => $auth[0]['userid'], 'username' => $auth[0]['username'], 'roleid' => $auth[0]['roleid']];
            }
        }
        return null;
    }

    /**
     * Фиксирует время входа в аккаунт.
     *
     * @param string $login Логин.
     */
    public static function setLoginTime(string $login) : void
    {
        lib\DBContext :: getInstance() -> Query('UPDATE users SET lastlogintime = now() WHERE login = :login',['login' => $login]);
    }

    /**
     * Полностью удаляет аккаунт.
     *
     * @param int $userId ID пользователя.
     */
    public static function removeAccount(int $userId)  : void
    {
        lib\DBContext :: getInstance() -> Query('DELETE FROM users WHERE userid = :userid',['userid' => $userId]);
    }

    /**
     * Проверяет логин на уникальность.
     *
     * @param string $login Логин.
     * @return bool
     */
    public static function checkLogin(string $login) : bool
    {
        $checkLogin = lib\DBContext :: getInstance() -> Select('SELECT 1 yes FROM users WHERE login=:login', ['login' => $login]);
        return $checkLogin && count($checkLogin) > 0;
    }

    /**
     * Проверяет email на уникальность.
     *
     * @param string $email email.
     * @return bool
     */
    public static function checkEmail(string $email) : bool
    {
        $checkEmail = lib\DBContext :: getInstance() -> Select('SELECT 1 yes FROM users WHERE email=:email', ['email' => $email]);
        return $checkEmail && count($checkEmail) > 0;
    }

    /**
     * Регистрирует аккаунт.
     *
     * @param string $login Логин.
     * @param string $passwd Пароль.
     * @param string $userName Имя пользователя.
     * @param string $email email.
     * @return mixed[] возвращает учетную информацию, либо код исключения.
     */
    public static function registerAccount(string $login, string $passwd, string $userName, string $email)
    {
        if (self :: checkLogin($login)) return -1;
        if (self :: checkEmail($email)) return -2;

        return lib\DBContext :: getInstance() -> Query('INSERT INTO users (username, email, login, passwd) VALUES(:username, :email, :login, :passwd)',
            ['username' => $userName, 'email' => $email, 'login' => $login, 'passwd' => $passwd]);
    }
}