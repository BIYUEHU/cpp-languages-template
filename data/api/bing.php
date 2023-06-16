<?php
$str = file_get_contents('https://cn.bing.com/HPImageArchive.aspx?idx=0&n=1');
preg_match("/<url>(.*?)<\/url>/", $str, $matches);
$imgurl = 'https://cn.bing.com' . $matches[1];
header("location: $imgurl");