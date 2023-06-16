<?php
header("Content-type: application/json");
$msg = $_REQUEST['msg'];
$format = $_REQUEST['format'];
$list = file_get_contents("http://43.250.238.179:9090/showData?callback=china_echarts");
$list = str_replace("value", "conNum", $list);
preg_match_all("/{\"name\":\"" . $msg . "\",\"conNum\":\"(.*?)\",\"susNum\":\"(.*?)\",\"deathNum\":\"(.*?)\",\"cureNum\":\"(.*?)\"/", $list, $data);
preg_match_all("/\"times\":\"截至(.*?)\",/", $list, $data2);

if ($format == 'text') {
    header('Content-type: text/plain');
    ($data[1][0] && $msg) || exit('没有搜索到有关的信息');
    $result = "查询地区：{$msg}\n";
    $result .= "目前确诊：{$data[1][0]}\n";
    $result .= "目前死亡：{$data[3][0]}\n";
    $result .= "目前治愈：{$data[4][0]}\n";
    $result .= "更新时间：{$data2[1][0]}";
    echo $result;
} else {
    if (!($data[1][0] && $msg)) {
        $result = array(
            'code' => 501,
            'message' => 'error',
            'data' => []
        );
    } else {
        $result = array(
            'code' => 500,
            'message' => 'success',
            'data' => array(
                'city' => $msg,
                'nowDiagnosed' => intval($data[1][0]),
                'nowDeath' => intval($data[3][0]),
                'nowCure' => intval($data[4][0]),
                'updateTime' => $data2[1][0]
            )
        );
    }
    echo stripslashes(urldecode(json_encode($result, 256)));
}
