<?php
    require_once(dirname(__DIR__) . '/config/config.php');
    require_once('resize_image.php');

    $fileName = $_FILES['photo']['name'];
    $fileSize = $_FILES['photo']['size'];
    $img = IMAGES . $fileName;
    $thumb = THUMBS . $fileName;
    $explode = explode(".", $fileName);
    $extension = $explode[sizeof($explode) - 1];

    if(!in_array($extension, ["png", "gif", "jpg", "jpeg"])){
        echo $fileName." имеет неверный формат!";
    } else {
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $_FILES['photo']['tmp_name']);
        $allowed_mime_types = ["image/jpg", "image/jpeg", "image/png", "image/gif"];
        if(!in_array($mime, $allowed_mime_types)){
            echo $fileName." имеет неверный формат!";
        } else {
            if($fileSize > 2*1024*1024)
            {
                echo $fileName." имеет слишком большой размер! Выберите файл до 2Мб!";
            }
            else
            {
                if(move_uploaded_file($_FILES['photo']['tmp_name'], $img)) {
                    if (resizeImage($img, $thumb, 200, $extension)) {
                        echo $fileName." успешно загружен!";
                    }
                }
            }
        }
    }
?>
<br><hr><br>
<a href="/public/" title="На главную" style="background:#ddd; padding: 5px 20px;">
<< на главную
</a>
