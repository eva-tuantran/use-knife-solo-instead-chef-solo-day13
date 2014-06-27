<?php

if (isset($_GET['file'])) {
    $file = $_GET['file'];
}

if ($file === '') {
    exit;
}

$img = new Imagick($file);
if (false === strpos($file, 'merged_')
    || (empty($_GET['width']) && empty($_GET['height']) && empty($_GET['dpi']))
) {
    header("Content-Type: image/jpeg");
    echo $img;
    exit;
}

// サイズを取得する
$original_width = $img->getImageWidth();
$original_height = $img->getImageHeight();

$width = 0;
if (! empty($_GET['width'])) {
    $width = $_GET['width'];
}
if ($width > $original_width) {
    $width = $original_width;
}

$height = 0;
if (! empty($_GET['height'])) {
    $height = $_GET['height'];
}
if ($height > $original_heigh) {
    $height = $original_heigh;
}

// 横縦共にサイズ指定がない場合、オリジナルサイズを指定する
if (empty($width) && empty($height)) {
    $width = $original_width;
    $height = $original_height;
}

$dpi = 0;
if (! empty($_GET['dpi'])) {
    $dpi = $_GET['dpi'];
} else {
    $resolution = $img->getImageResolution();
    $dpi = $resolution['x'];
}

$img->resampleImage($dpi, $dpi, Imagick::FILTER_POINT, 0);
//$img->resizeImage($width, $height, Imagick::FILTER_POINT, 0);

header("Content-Type: image/jpeg");
echo $img;
