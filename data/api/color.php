<?php

// 获取r、g、b参数,如果无效则随机生成
$r = isset($_GET['r']) && $_GET['r'] >= 0 && $_GET['r'] <= 255 ? $_GET['r'] : mt_rand(0, 255);
$g = isset($_GET['g']) && $_GET['g'] >= 0 && $_GET['g'] <= 255 ? $_GET['g'] : mt_rand(0, 255);
$b = isset($_GET['b']) && $_GET['b'] >= 0 && $_GET['b'] <= 255 ? $_GET['b'] : mt_rand(0, 255);

// 创建1280x720图片
$img = imagecreatetruecolor(1280, 720);

// 分配颜色
$bgColor = imagecolorallocate($img, $r, $g, $b);
$textColor = imagecolorallocate($img, max(0, $r - 32), max(0, $g - 32), max(0, $b - 32));

// 填充背景  
imagefilledrectangle($img, 0, 0, 1280, 720, $bgColor);

// 格式化RGB/十六进制值/HSL
$rgb = sprintf("rgb(%d,%d,%d)", $r, $g, $b);
$hex = sprintf("#%02X%02X%02X", $r, $g, $b);
$hsl = sprintf("hsl(%d,%d%%,%d%%)", round($r / 255 * 360), round($g / 255 * 100), round(($b / 255) * 100));

// 绘制文本  
$font = __DIR__ . "/res/font.ttf";

// 计算文字总行数和最大行宽  
$text = "$rgb\n$hex\n$hsl";
$lines = explode("\n", $text);
$line_count = count($lines);
$max_width = 0;
foreach ($lines as $line) {
  $box = imagettfbbox(90, 0, $font, $line);
  $width = $box[2] - $box[0];
  $max_width = max($max_width, $width);
}

// 计算文字绘制起点坐标
$x = (imagesx($img) - $max_width) / 2;
$y = (imagesy($img) - $line_count * 20) / 2;

// 绘制文字
foreach ($lines as $line) {
  $box = imagettfbbox(90, 0, $font, $line);
  $line_width = $box[2] - $box[0];
  imagettftext($img, 90, 0, $x + ($max_width - $line_width) / 2, $y, $textColor, $font, $line);
  $y += 95; // 行高20像素
}

// 输出图片

// 输出图片
header('Content-type: image/png');
imagepng($img);
imagedestroy($img);
