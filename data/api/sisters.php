<?php
// header('Content-Type: video/mp4');

$str = explode("\n", file_get_contents(__DIR__ . '/res/imgs/sisters.txt'));
$k = rand(0, count($str));
$video = $str[$k];

\Core\Func\location($video);