<?php

function handle($str)
{
  $str = str_replace(' ', "", $str);
  $str = str_replace("\n", "", $str);
  $str = str_replace("\t", "", $str);
  $str = str_replace("\r", "", $str);
  return $str;
}

$list = explode("\n", file_get_contents(__DIR__ . '/res/beautyimg.txt'));
$data = handle($list[rand(0, count($list) - 1)]);

$url = strstr($data, "http") === false ? 'http://p.ananas.chaoxing.com/star3/origin/' . $data . '.png' : $data;

header("location: {$url}");
