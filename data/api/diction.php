<?php
header("Content-type: application/json");
$msg = $_REQUEST['msg'];
if ($msg == null) {
    $result = array(
        "code" => 501,
        "message" => "error",
        "data" => []
    );
} else {
    $bbb = file_get_contents("http://www.hifang.net/01xinhua/show.asp?q=" . $msg);
    preg_match_all("/查询的字：<span class=\"red f14\">(.*?)</", $bbb, $dd1);
    preg_match_all("/音节：<span class=\"dicpy\">(.*?)<\/span>&/", $bbb, $dd2);
    preg_match_all("/部首：<span class=\"diczx4\">(.*?)</", $bbb, $dd3);
    preg_match_all("/部首笔画：<span class=\"diczx4\">(.*?)</", $bbb, $dd4);
    preg_match_all("/部外笔画：<span class=\"diczx4\">(.*?)</", $bbb, $dd5);
    preg_match_all("/总笔画：<span class=\"diczx4\">(.*?)</", $bbb, $dd6);
    preg_match_all("/笔顺：<span class=\"diczx4\">(.*?)</", $bbb, $dd7);
    $dd1 = $dd1[1][0];
    $dd2 = $dd2[1][0];
    $dd3 = $dd3[1][0];
    $dd4 = $dd4[1][0];
    $dd5 = $dd5[1][0];
    $dd6 = $dd6[1][0];
    $dd7 = $dd7[1][0];
    $result = array(
        "code" => 500,
        "message" => "success",
        "data" => array(
            "word" => $dd1,
            "yinjie" => $dd2,
            "bushou" => $dd3,
            "bushounum" => intval($dd4),
            "buwainum" => intval($dd5),
            "num" => intval($dd6),
            "method" => intval($dd7)
        )
    );
}
echo stripslashes(urldecode(json_encode($result, 256)));
