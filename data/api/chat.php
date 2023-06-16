<?php
function curl($url, $post)
{
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($curl);
    curl_close($curl);
    return $output;
}

header("content-type:application/json");

$msg = $_REQUEST["msg"];
if (empty($msg)) {
    $code = 501;
} else {
    $msg = str_replace("ISLA", "智娃", $msg);
    $url = "http://biz.turingos.cn/apirobot/dialog/homepage/chat";
    $post = "deviceId=70b270b2-70b2-70b2-70b2-70b270b270b2&question=" . $msg;
    $data = curl($url, $post);
    $json = json_decode($data, true);
    $str = $json["data"]["results"][0]["values"]["text"];
    $str = str_replace("智娃", "ISLA", $str);
    $code = 500;
}

$result = array(
    "code" => $code,
    "message" => $code == 500 ? "success" : "error",
    "data" => $str
);
echo json_encode($result, 256);
