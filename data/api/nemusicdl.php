<?php

/**
 * 网易云音乐解析
 * 作者：iqiqiya (77sec.cn)
 * 日期：2018/12/10
 * 博客: blog.77sec.cn
 */

header("Content-Type: application/json");
$id = $_REQUEST['id'];

$MusicUrl = "http://music.163.com/api/song/enhance/player/url?id=" . $id . "&ids=[" . $id . "]&br=3200000";
$temp = json_decode(file_get_contents($MusicUrl));
header('Content-Type:application/json; charset=utf-8');
$result = array(
    'code' => $temp->code == 200 ? 500 : 501,
    'message' => $temp->code == 200 ? 'success' : 'error',
    'data' => array(
        'id' => $temp->data[0]->id,
        'type' => $temp->data[0]->type,
        'md5' => $temp->data[0]->md5,
        'size' => $temp->data[0]->size,
        'url' => $temp->data[0]->url
    )
);
echo stripslashes(urldecode(json_encode($result, 256)));
