<?php
    define('SITE', dirname(__DIR__) . '/');
    define('SRV', SITE . 'server/');
    define('PUB', SITE . 'public/');
    define('TMPLS', SITE . 'templates/');
    define('TWIG', SITE . 'vendor/twig/twig/lib/Twig/');
    define('IMAGES', PUB . 'images/');
    define('THUMBS', PUB . 'thumbnails/');

    require_once(TWIG . 'Autoloader.php');

    Twig_Autoloader::register();