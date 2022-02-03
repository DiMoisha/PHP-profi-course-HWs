<?php
    define('SITE', dirname(__DIR__) . '/');
    define('CONF', SITE . 'config/');
    define('SRV', SITE . 'server/');
    define('ENGINE', SITE . 'engine/');
    define('PUB', SITE . 'public/');
    define('TMPLS', SITE . 'templates/');
    define('TWIG', SITE . 'vendor/twig/twig/lib/Twig/');
    define('IMAGES', PUB . 'images/');
    define('THUMBS', PUB . 'thumbnails/');

    require_once(TWIG . 'Autoloader.php');

    Twig_Autoloader::register();