<?php
/*
 * @Author: Biyuehu biyuehuya@gmail.com
 * @Blog: http://imlolicon.tk
 * @Date: 2023-01-17 21:03:19
 */
header('Content-type: application/json');

$msg = $_REQUEST['msg'];
$list = [
    '白羊座' => 'aries',
    '金牛座' => 'taurus',
    '双子座' => 'gemini',
    '巨蟹座' => 'cancer',
    '狮子座' => 'leo',
    '处女座' => 'virgo',
    '天秤座' => 'libra',
    '天蝎座' => 'scorpio',
    '射手座' => 'sagittarius',
    '摩羯座' => 'capricorn',
    '水瓶座' => 'aquarius',
    '双鱼座' => 'pisces',
];
$msg = $list[$msg];

$data = [];
if (empty($msg)) {
    $code = 501;
} else {
    $res = file_get_contents('https://www.xzw.com/fortune/aries');

    preg_match_all('/健康指数：<\/label>(.*?)</', $res, $info1);
    preg_match_all('/商谈指数：<\/label>(.*?)</', $res, $info2);
    preg_match_all('/幸运颜色：<\/label>(.*?)</', $res, $info3);
    preg_match_all('/幸运数字：<\/label>(.*?)</', $res, $info4);
    preg_match_all('/速配星座：<\/label>(.*?)</', $res, $info5);
    preg_match_all('/短评：<\/label>(.*?)</', $res, $info6);
    
    preg_match_all('/综合运势<\/strong><span>(.*?)</', $res, $index1);
    preg_match_all('/爱情运势<\/strong><span>(.*?)</', $res, $index2);
    preg_match_all('/事业学业<\/strong><span>(.*?)</', $res, $index3);
    preg_match_all('/财富运势<\/strong><span>(.*?)</', $res, $index4);
    preg_match_all('/健康运势<\/strong><span>(.*?)</', $res, $index5);

    $data = array(
        'name' => $_REQUEST['msg'],
        'info' => [
            '健康指数：' . $info1[1][0],
            '商谈指数：' . $info2[1][0],
            '幸运颜色：' . $info3[1][0],
            '幸运数字：' . $info4[1][0],
            '速配星座：' . $info5[1][0],
            '短评：' . $info6[1][0],
        ],
        'index' => [
            '综合运势：' . $index1[1][0],
            '爱情运势：' . $index2[1][0],
            '事业学业：' . $index3[1][0],
            '财富运势：' . $index4[1][0],
            '健康运势：' . $index5[1][0]
        ]
    );
    $code = 500;
}

$result = array(
    'code' => $code,
    'message' => $code == 500 ? 'success' : 'error',
    'data' => $data
);

echo stripslashes(json_encode($result, 256));
