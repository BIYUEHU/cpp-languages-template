<?php
function post_data_test($url, $data)
{
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 1);
    curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    curl_setopt($curl, CURLOPT_TIMEOUT, 30);
    curl_setopt($curl, CURLOPT_HEADER, 0);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $result = curl_exec($curl);
    if (curl_errno($curl)) {
        echo '错误信息;' . curl_error($curl);
    }
    curl_close($curl);
    return $result;
}

header('Content-Type: application/json');

$msg = $_REQUEST['msg'];
$url = "http://m.youdao.com/translate";
$data = "inputtext=" . $msg . "&type=AUTO";
$data = post_data_test($url, $data);
preg_match_all("/<li>(.*?)<\/li>/", $data, $aa1);
$aa2 = $aa1[1][2];

$result = array(
    'code' => 500,
    'message' => 'success',
    'data' => $aa2
);

echo stripslashes(urldecode(json_encode($result, 256)));
