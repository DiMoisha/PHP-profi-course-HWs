<?php
    define('DB_SERVER', 'localhost');
    define('DB_USER', 'root');
    define('DB_PASSWORD', '');
    define('DB_DBNAME', 'photogallery');

    $dbconn = null;

    try {
        $dbconn = new PDO('mysql:dbname='.DB_DBNAME.';host='.DB_SERVER,
            DB_USER,
            DB_PASSWORD,
                    array(
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
                    ));
    } catch (PDOException $ex) {
        echo "Error: Could not connect. " . $ex -> getMessage();
    } finally {

    }