<?php
header('Content-Type: application/json');
$op = intval($_REQUEST['op']);
$code = $_REQUEST['code'];

function encode($code)
{
    $code = str_replace(array('<?php', '?>', '<?PHP'), array('', '', ''), $code);
    $encode = base64_encode(gzdeflate($code));
    $encode = '<?php /* @By Biyuehu @Blog: http://hotaru.icu */ ' . "eval(gzinflate(base64_decode(" . "'" . $encode . "'" . ")));\n?>";
    return $encode;
}

function decode($code)
{
    $maxTimes = 1000; //最大循环解密次数
    $matches = [];
    $decode = '';
    for ($i = 0; $i < $maxTimes; $i++) {
        $arr = preg_split('/\r\n|\r|\n/', $code);
        $match = false;
        foreach ($arr as $s) {
            if (preg_match('/eval\((gzinflate\(base64_decode\([\'\"]([\w\/=+]+)[\'\"]\)\))\)/', $s, $matches)) {
                ob_start();
                eval('echo ' . $matches[1] . ';');
                $decode = '<?php ' . trim(ob_get_clean()) . '?>';
                $match = true;
                break;
            }
        }
        if (!$match) {
            break;
        }
    }
    return $decode;
}

$result = $op != 1 ? encode($code) : decode($code);

$result = array(
    'code' => 500,
    'message' => 'success',
    'data' => $result
);

$result = urldecode(json_encode($result, 256));
echo str_replace('\/', '/', $result);
