<?php
header('content-type:application/json;charset=utf-8');

$msg = $_GET["msg"];
$url = "https://fanyi.baidu.com/gettts?lan=zh&spd=4&source=web&text=" . $msg . "";

header("location: {$url}");
