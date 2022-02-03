<?php
    function getImages($imageId, $limit) {
        require_once dirname(__DIR__) . '/config/config.php';
        require_once CONF . 'dbconfig.php';

        if (isset($dbconn)) {
            $images = $dbconn ->
                query("SELECT imageid id, imagename image FROM images WHERE imageid > $imageId ORDER BY imageid LIMIT $limit") ->
                fetchAll(PDO::FETCH_KEY_PAIR);
        } else {
            $images = [];
        }

        return $images;
    }