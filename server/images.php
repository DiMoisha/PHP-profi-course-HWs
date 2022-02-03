<?php
    try {
        if(isset($_GET['id']) && isset($_GET['limit'])) {
            $imageId = $_GET['id'];
            $limit = $_GET['limit'];

            require_once dirname(__DIR__) . '/config/config.php';
            require_once ENGINE . 'get_images.php';
            $images = getImages($imageId, $limit);

            if (count($images) > 0) {
                $loader = new Twig_Loader_Filesystem(TMPLS);
                $twig = new Twig_Environment($loader);
                $template = $twig -> loadTemplate('image_list_item.html.twig');
                echo $template -> render(['images' => $images]);
            }
        }
    } catch (Exception $ex) {
        die ('ERROR: ' . $ex -> getMessage());
    }