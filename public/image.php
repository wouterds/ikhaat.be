<?php

function loadJpgFromFile($path) {
    $img = @imagecreatefromjpeg($path);

    if ($img) {
        return $img;
    }

    $img  = imagecreatetruecolor(150, 30);
    $bgc = imagecolorallocate($img, 255, 255, 255);
    $tc  = imagecolorallocate($img, 0, 0, 0);

    imagefilledrectangle($img, 0, 0, 150, 30, $bgc);
    imagestring($img, 2, 10, 10, 'Error loading ' . $path, $tc);

    return $img;
}

function wrap($fontSize, $fontFace, $string, $width){
    $ret = "";
    $arr = explode(' ', $string);

    foreach ( $arr as $word ){
        $teststring = $ret.' '.$word;
        $testbox = imagettfbbox($fontSize, 0, $fontFace, $teststring);
        if ( $testbox[2] > $width ){
            $ret.=($ret==""?"":"\n").$word;
        } else {
            $ret.=($ret==""?"":' ').$word;
        }
    }

    return $ret;
}

$img = loadJpgFromFile('../media/images/ik-haat-wandelen.jpg');

if(isset($_GET['text']) && !empty($_GET['text'])) {
    $t = substr(strtoupper($_GET['text']), 0, 55);
    $f = '../media/fonts/Primrose.ttf';
    $fs = 20;
    $c = imagecolorallocate($img, 35, 35, 35);

    imagettftext($img, $fs, 0, 300, 120, $c, $f, wrap($fs, $f, $t, 173));
}

header('Content-Type: image/jpeg');

imagejpeg($img);
imagedestroy($img);
