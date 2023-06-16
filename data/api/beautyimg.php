<?php

$temp = rand(1, 2);
$temp == 1 ? $temp = null : $temp;
$str = explode("\n", file_get_contents(__DIR__ . '/res/imgs/beautyimg' . $temp . '.txt'));
$k = rand(0, count($str));
$sina_img = str_re($str[$k]);

$size_arr = array('large', 'mw1024', 'mw690', 'bmiddle', 'small', 'thumb180', 'thumbnail', 'square');
$size = !empty($_GET['size']) ? $_GET['size'] : 'large';
$server = rand(1, 4);
if (!in_array($size, $size_arr)) {
  $size = 'large';
}
$url = 'http://tva' . $server . '.sinaimg.cn/' . $size . '/' . $sina_img . '.jpg';

/* $img = file_get_contents($url,true);
header("Content-Type: image/jpeg;");
echo $img; */
header("location: {$url}");

function str_re($str)
{
  $str = str_replace(' ', "", $str);
  $str = str_replace("\n", "", $str);
  $str = str_replace("\t", "", $str);
  $str = str_replace("\r", "", $str);
  return $str;
}
