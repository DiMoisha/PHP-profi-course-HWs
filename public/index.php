<!--
    Урок 4. Углубленное проектирование реляционных БД
    1. Подгрузка контента с помощью AJAX.
        а) На базе движка из курса «PHP. Уровень 1» взять модуль каталога.
        б) Выводить не все товары разом, а подгружать по 25 по нажатию кнопки «Еще».
    2. Создать очень много товаров и попробовать дойти до конца списка. Что происходит? Почему?
-->
<?php
    try {
        require_once dirname(__DIR__) . '/config/config.php';
        require_once ENGINE . 'get_images.php';

        $loader = new Twig_Loader_Filesystem(TMPLS);
        $twig = new Twig_Environment($loader);
        $template = $twig -> loadTemplate('layout.html.twig');

        echo $template -> render([
                        'isMain' => true,
                        'pageTitle' => 'Фотогалерея | Главная',
                        'pageHeading' => 'ФОТОГАЛЕРЕЯ',
                        'images' => getImages(0, 10),
                        'footerYear' => date('Y')
                    ]);
    } catch (Exception $ex) {
        die ('ERROR: ' . $ex -> getMessage());
    }