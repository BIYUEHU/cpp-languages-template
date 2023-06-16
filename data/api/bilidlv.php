<?php
header('Content-Type: application/json');

$msg = $_REQUEST['msg'];
if (!empty($msg)) {
    $aid = json_decode(file_get_contents("http://zhouql.vip:8080/bili/av/{$msg}"))->data->aid;
    $cid = json_decode(file_get_contents("http://zhouql.vip:8080/bili/av/{$msg}"))->data->pages[0]->cid;

    $dataTemp = json_decode(file_get_contents("http://zhouql.vip:8080/bili/download/{$aid}/{$cid}"));
    if ($dataTemp->code === 0) {
        $dataTemp = $dataTemp->data;
        $data = array(
            'type' => $dataTemp->format,
            'typelist' => $dataTemp->accept_description,
            'timelength' => $dataTemp->timelength,
            'size' => $dataTemp->durl[0]->size,
            'url' => $dataTemp->durl[0]->url
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
