<?php
$str = explode("\n", file_get_contents(__DIR__ . '/res/imgs/sedimg.txt'));
$k = rand(0, count($str));
$sina_img = str_re($str[$k]);

$url = 'http://p.ananas.chaoxing.com/star3/origin/' . $sina_img . '.png';

//解析JSON
function str_re($str)
{
  $str = str_replace(' ', "", $str);
  $str = str_replace("\n", "", $str);
  $str = str_replace("\t", "", $str);
  $str = str_replace("\r", "", $str);
  return $str;
}


/* header('Content-Type: image/png');
$content = file_get_contents($url);
echo $content; */
header("location: {$url}");
