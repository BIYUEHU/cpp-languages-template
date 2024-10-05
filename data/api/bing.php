<?php
$str = file_get_contents('https://cn.bing.com/HPImageArchive.aspx?idx=0&n=1');
preg_match("/<url>(.*?)<\/url>/", $str, $matches);
$imgurl = 'https://cn.bing.com' . $matches[1];
preg_match("/<copyright>(.*?)<\/copyright>/", $str, $matches2);
$copyright = $matches2[1];
if ($_REQUEST["format"] == "json") {
  header("Content-type: application/json");
   echo json_encode(array(
    "code" => 200,
    "data" => array(
       "url" => $imgurl,
       "copyright" => $copyright
    )
   ), 256);
} else {
   header("location: $imgurl");
}