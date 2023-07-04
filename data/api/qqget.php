<?php
header('Content-Type: application/json');

if ($_REQUEST['qq']) {
    $qq = $_REQUEST['qq'];
    $get_info = file_get_contents('http://r.qzone.qq.com/fcg-bin/cgi_get_portrait.fcg?get_nick=1&uins=' . $qq);
    $get_info = mb_convert_encoding($get_info, "UTF-8", "GBK");
    $name = json_decode(substr($get_info,17,-1),true);
    
    // if ($name) { 
        $txUrl = 'https://q.qlogo.cn/headimg_dl?spec=100&dst_uin='.$qq.'';
        $arr = array(
            'code' => 500,
            'message' => 'success',
            'data' => array(
                'imgurl' => $txUrl,
                'name' => urlencode($name[$qq][6])
        ));
    /* } else {
        $arr = array(
            'code' => 501,
            'message' => 'error',
            'data' => []
        );
    }*/
} else {
    $arr = array(
        'code' => 501,
        'message' => 'error',
        'data' => []
    );
}
echo stripslashes(urldecode(json_encode($arr, 256)));
