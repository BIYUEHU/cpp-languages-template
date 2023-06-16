<?php
/*
 * @Author: Biyuehu biyuehuya@gmail.com
 * @Blog: http://imlolicon.tk
 * @Date: 2022-12-21 19:53:25
 */
header('Content-Type: application/json');

$num = $_REQUEST["num"];
$num = number_format($num);
$num >= 1 ? $num : $num = 1;

function uuidGet()
{
    $chars = md5(uniqid(mt_rand(), true));
    $uuid = substr($chars, 0, 8) . '-'
        . substr($chars, 8, 4) . '-'
        . substr($chars, 12, 4) . '-'
        . substr($chars, 16, 4) . '-'
        . substr($chars, 20, 12);
    return $uuid;
}

$data = [];
for ($i = 0; $i < $num; $i++) {
    array_push($data, uuidGet());
}

$result = array(
    'code' => 500,
    'message' => 'success',
    'data' => $data
);

echo stripslashes(urldecode(json_encode($result, 256)));
