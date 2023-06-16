<?php

$str = explode("\n", file_get_contents(__DIR__ . '/res/imgs/cosimg.txt'));
$k = rand(0, count($str));
$url = $str[$k];

header("location: {$url}");
