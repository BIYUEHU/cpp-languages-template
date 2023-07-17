<?php
header('Content-Type: application/json');

$msg = $_REQUEST['msg'];
if (!empty($msg)) {
    $dataTemp = json_decode(file_get_contents("http://zhouql.vip:8080/bili/av/{$msg}"));
    if ($dataTemp->code === 0) {
        $dataTemp = $dataTemp->data;
        $data = array(
            'bvid' => $dataTemp->bvid,
            'aid' => $dataTemp->aid,
            'title' => $dataTemp->title,
            'pic' => $dataTemp->pic,
            'ctime' => $dataTemp->ctime,
            'descr' => $dataTemp->desc,
            'owner' => array(
                'uid' => $dataTemp->owner->mid,
                'name' => $dataTemp->owner->name,
                'img' => $dataTemp->owner->face
            )
        );

        $result = array(
            'code' => 500,
            'message' => 'success',
            'data' => $data
        );
    } else {
        $result = array(
            'code' => 502,
            'message' => 'fail:parameter error',
            'data' => null,
        );
    }
} else {
    $result = array(
        'code' => 501,
        'message' => 'fail:parameter cannot be empty',
        'data' => null,
    );
}

echo stripslashes(urldecode(json_encode($result, 256)));
