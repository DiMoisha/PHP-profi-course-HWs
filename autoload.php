<?php
namespace App;

require_once 'lib/Twig/Autoloader.php';
\Twig_Autoloader :: register();

\spl_autoload_register("App\gbStandardAutoload");

function gbStandardAutoload($className)
{
    $dirs = [
        'config',
        'controllers',
        'data/migrate',
        'lib',
        'lib/smarty',
        'lib/commands',
        'models/'
    ];
    $found = false;
    $aClassName = explode('\\',$className);
    $class = $aClassName[array_key_last($aClassName)];

    foreach ($dirs as $dir) {
        $fileName = __DIR__ . '/' . $dir . '/' . $class . '.class.php';
        if (is_file($fileName)) {
            require_once($fileName);
            $found = true;
        }
    }
    //$obj = new A;

//      Это пока не нужно - исключение обрабатывается в классе App - где выдается представление 404 notFound
//      if (!$found) {
//          throw new Exception('Не получилось загрузить ' . $className);
//      }

    return true;
}


//$object = new Test;

