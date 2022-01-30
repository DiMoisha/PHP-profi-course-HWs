<!--
    Профессиональная веб-разработка на PHP
    Урок 3. Шаблонизаторы
    1. Создать галерею изображений, состоящую из двух страниц:
        ### а) Просмотр всех фотографий (уменьшенных копий);
        ### б) Просмотр конкретной фотографии (изображение оригинального размера)
        ### в) Все страницы вывода на экран – это twig-шаблоны. Вся логика – на бэкенде.
        ### г) *Реализовать хранение ссылок и информации по картинкам в БД.
-->
<?php
    require_once(dirname(__DIR__) . '/config/config.php');

    try {
        $loader = new Twig_Loader_Filesystem(TMPLS);
        $twig = new Twig_Environment($loader);
        $template = $twig -> loadTemplate('layout.html.twig');
        $images = array_slice(scandir(IMAGES), 2);

        echo $template -> render([
                'isMain' => true,
                'pageTitle' => 'Фотогалерея | Главная',
                'pageHeading' => 'ФОТОГАЛЕРЕЯ',
                'images' => $images,
                'footerYear' => date('Y')
            ]);
    } catch (Exception $ex) {
        die('ERROR: ' . $ex -> getMessage());
    }