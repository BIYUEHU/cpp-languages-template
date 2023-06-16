<?php
$main = imagecreatefromjpeg(__DIR__ . '/res/wall/qb.jpg');
$fontSize = 45;
$width   = imagesx($main);
$height   = imagesy($main);
//1.设置字体的路径
$font    = __DIR__ . "/res/font.ttf";
//2.填写内容
$msg = $_GET['msg'];
//3.设置字体颜色和透明度
$color   = imagecolorallocatealpha($main, 255, 0, 0, 0);
$fontBox = imagettfbbox($fontSize, 0, $font, $msg); //获取文字所需的尺寸大小 
//4.写入文字 (图片资源，字体大小，旋转角度，坐标x，坐标y，颜色，字体文件，内容)
imagettftext($main, $fontSize, 0, ceil(($width - $fontBox[2]) / 2), ceil(($height - $fontBox[1] - $fontBox[7]) / 2), $color, $font, $msg);
// 浏览器输出 也可以换成保存新图片资源
header("Content-type: image");
imagejpeg($main);
