<?php
header('Content-Type: application/json');

$msg = urlencode($_REQUEST['msg']);
$line = $_REQUEST['line'];
$url = 'http://s.music.163.com/search/get/?src=lofter&type=1&filterDj=true&limit=30&offset=0&s=' . $msg;
$str = file_get_contents($url);
$match = '/{"id":(.*?),"name":"(.*?)","artists":\[{"id":(.*?),"name":"(.*?)","picUrl":(.*?)}\],"album":{"id":(.*?),"name":"(.*?)","artist":{"id":(.*?),"name":"(.*?)","picUrl":(.*?)},"picUrl":"(.*?)"},"audio/';
$nums = preg_match_all($match, $str, $dataTemp);


$errorCode = array(
    500 => 'success',
    511 => 'fail:not found'
);

$data = [];
if ($nums == 0) {
    $code = 511;
} else {
    if (empty($line)) {
        for ($i = 0; $i < $nums && $i < 15; $i++) {
            $musicName = $dataTemp[2][$i];
            $musicSinger = $dataTemp[4][$i];
            array_push($data, $musicName . ' - ' . $musicSinger);
        }
        $code = 500;
    } else {
        $i = ($line - 1);
        if (count($dataTemp[1]) > 0) {
            $musicId = $dataTemp[1][$i];
            $musicName = $dataTemp[2][$i];
            $musicSinger = $dataTemp[4][$i];
            $musicCover = $dataTemp[11][$i];
            $musicUrl = 'http://music.163.com/song/media/outer/url?id=' . $musicId;

            $data = array(
                'id' => $musicId,
                'name' => $musicName,
                'singer' => $musicSinger,
                'cover' => $musicCover,
                'url' => $musicUrl
            );
            $code = 500;
        } else {
            $code = 511;
        }
    }
}

$result = array(
    'code' => $code,
    'message' => $errorCode[$code],
    'data' => $data
);
echo stripslashes(urldecode(json_encode($result, 256)));
