<?php
function handle($txt1, $q1, $h1) {
    $txt1 = strstr($txt1, $q1);
    $cd = strlen($q1);
    $txt1 = substr($txt1, $cd);
    $txt1 = strstr($txt1, $h1, true);
    return str_replace(' ','',$txt1);
}

header('Content-Type: application/json');

$msg = $_REQUEST['msg'];

// 检查参数是否为空
if (empty($msg)) {
    echo json_encode([
        'code' => 501,
        'message' => 'fail: parameter cannot be empty'
    ]);
    exit;
}

// 获取城市列表数据
preg_match_all("/{\"cityId\":(.*?),\"city_lable\":(.*?),\"counname\":\"(.*?)\",\"id\":(.*?),\"localCounname\":\"(.*?)\",\"localName\":\"(.*?)\",\"localPname\":\"(.*?)\",\"name\":\"(.*?)\",\"pname\":\"(.*?)\"}/", file_get_contents("http://m.moji.com/api/citysearch/" . $msg), $matches);

if (!$matches[1][0]) {
    echo json_encode([
        'code' => 502,
        'message' => 'fail: parameter error'
    ]);
    exit;
}

// 正则表达式提取天气详情
$weatherInfo = handle(file_get_contents("http://m.moji.com/api/redirect/" . $matches[1][0]), "<div class=\"weak_wea\">", "<div class=\"exponent\">");
preg_match_all("/<lidata-high=\"(.*?)\"data-low=\"(.*?)\">/", $weatherInfo, $temperatureMatches);
preg_match_all("/<em>(.*?)<\/em>/", $weatherInfo, $dateMatches);
preg_match_all("/<dd><strong>(.*?)<\/strong><\/dd>/", $weatherInfo, $weatherConditionMatches);
preg_match_all("/<pclass=\"(.*?)\">(.*?)<\/p><dlclass=\"wind\">/", $weatherInfo, $airQualityMatches);
preg_match_all("/<dd>(.*?)<\/dd>/", $weatherInfo, $windMatches);

if ($temperatureMatches) {
    echo json_encode([
        'code' => 500,
        'message' => 'success',
        'data' => [
            'city' => $matches[6][0],
            'list' => [
                [
                    'date' => $dateMatches[1][0], // 日期
                    'temperature' => [intval($temperatureMatches[2][0]), intval($temperatureMatches[1][0])], 
                    'condition' => $weatherConditionMatches[1][0], // 天气情况
                    'wind' => [$windMatches[1][2], $windMatches[1][3]], // 风度
                    'air_quality' => $airQualityMatches[2][0] // 空气质量
                ],
                [
                    'date' => $dateMatches[1][1],
                    'temperature' => [intval($temperatureMatches[2][1]), intval($temperatureMatches[1][1])],
                    'condition' => $weatherConditionMatches[1][1],
                    'wind' => [$windMatches[1][6], $windMatches[1][7]],
                    'air_quality' => $airQualityMatches[2][1]
                ],
                [
                    'date' => $dateMatches[1][2],
                    'temperature' => [intval($temperatureMatches[2][2]), intval($temperatureMatches[1][2])],
                    'condition' => $weatherConditionMatches[1][2],
                    'wind' => [$windMatches[1][10], $windMatches[1][11]],
                    'air_quality' => $airQualityMatches[2][2]
                ]
            ]
        ]
    ]);
} else {
    echo json_encode([
        'code' => 502,
        'message' => 'fail: parameter error'
    ]);
}