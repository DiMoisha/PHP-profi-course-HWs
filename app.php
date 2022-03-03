<?php
namespace App;

use App\Lib as lib;
use Exception;
use PDOException;

require_once 'autoload.php';

try {
    lib\App :: init();
}
catch (PDOException $ex) {
    echo "Ошибка доступа к базе данных!";
    //var_dump($ex -> getTrace());
}
catch (Exception $ex) {
    echo $ex -> getMessage();
}