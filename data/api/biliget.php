<?php
header('Content-Type: application/json');

$result = array(
    'code' => 502,
    'message' => 'error',
    'data' => []
);

if ($_REQUEST['uid']) {

    $uid = intval($_REQUEST['uid']);

    $data = file_get_contents('https://space.bilibili.com/' . $uid);
    preg_match_all('/关注(.*?)账号/', $data, $name);
    preg_match_all('/"apple-touch-icon" href="(.*?)">/', $data, $imgurl);
    $name = $name[1][0];
    $imgurl = 'https:' . $imgurl[1][0];

    if ($imgurl && $name) {
        $result = array(
            'code' => 500,
            'message' => 'success',
            'data' => array(
                'imgurl' => $imgurl,
                'name' => $name
            )
        );
    }
} else {
    $result = array(
        'code' => 501,
        'message' => 'error',
        'data' => []
    );
}
echo stripslashes(urldecode(json_encode($result, 256)));
