<?php
    function resizeImage($file, $newfile, $w, $type = "jpg") {
        list($width, $height) = getimagesize($file);
        $k = $width / $height;

        $newwidth = $w;
        $newheight = $w / $k;

        if ($type == "png") {
            $src = imagecreatefrompng($file);
        } else if ($type == "gif") {
            $src = imagecreatefromgif($file);
        } else {
            $src = imagecreatefromjpeg($file);
        }

        $dst = imagecreatetruecolor($newwidth, $newheight);
        imagecopyresampled($dst, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

        if ($type == "png" || $type == "gif") {
            imagepng($dst, $newfile);
        } else {
            imagejpeg($dst, $newfile, 80);
        }

        imagedestroy($dst);

        return true;
    }
