<?php
header('content-type:application/json');

$startdate = $_REQUEST["start"]; //输开始
$enddate = $_REQUEST["end"]; //输结束

$startdate == null ? $startdate = date('Y-m-d H:i:s') : $startdate;
$enddate == null ? $enddate = date('Y-m-d H:i:s') : $enddate;

$date = floor((strtotime($enddate) - strtotime($startdate)) / 86400);
$hour = floor((strtotime($enddate) - strtotime($startdate)) % 86400 / 3600);
$minute =  floor((strtotime($enddate) - strtotime($startdate)) % 86400 / 60);
$second = floor((strtotime($enddate) - strtotime($startdate)) % 86400 % 60);

$result = array(
    "code" => 500,
    "message" => "success",
    "data" => array(
        "day" => $date,
        "hour" => $hour,
        "minute" => $minute,
        "second" => $second,
    )
);
echo stripslashes(urldecode(json_encode($result, 256)));
