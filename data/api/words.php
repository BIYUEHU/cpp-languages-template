<?php
header('Content-Type: application/json');

function handelStr($str)
{
    // $str = str_replace(' ', "", $str);
    $str = str_replace("\n", "", $str);
    $str = str_replace("\t", "", $str);
    $str = str_replace("\r", "", $str);
    return $str;
}

$msg = intval($_REQUEST['msg']);
$msg = $msg < 1 || $msg > 16 || empty($msg) ? rand(1, 16) : $msg;
$format = $_REQUEST['format'];

$list = [
    1 => ['yan', '一言'],
    2 => ['saohua', '骚话'],
    3 => ['like', '情话'],
    4 => ['life', '人生语录'],
    5 => ['socwords', '社会语录'],
    6 => ['badsoup', '毒鸡汤'],
    7 => ['jokes', '笑话'],
    8 => ['sadness', '网抑云'],
    9 => ['gentle', '温柔语录'],
    10 => ['dog', '舔狗语录'],
    11 => ['love', '爱情语录'],
    12 => ['sign', '个性签名'],
    13 => ['renjian', '人间'],
    14 => ['classics', '经典语录'],
    15 => ['ce', '英汉语录'],
    16 => ['poetry', '诗词'],
];

$file = file(__DIR__ . '/res/words/' . $list[$msg][0] . '.txt');
$fileCount = count($file);
$rand = rand(1, $fileCount);

$text = handelStr($file[$rand], 256);

if ($format == 'text') {
    header('Content-type: text/plain');
    echo $text;
} else {
    $result = array(
        'code' => 500,
        'message' => 'success',
        'data' => array(
            'msg' => $text,
            'type' => $list[$msg][1]
        )
    );

    echo stripslashes(urldecode(json_encode($result, 256)));
}