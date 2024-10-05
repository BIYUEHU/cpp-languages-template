<?php
/*
 * @Author: Biyuehu biyuehuya@gmail.com
 * @Blog: http://hotaru.icu
 * @Date: 2022-10-02 21:22:06
 */
header('Access-Control-Allow-origin: *');
header('Content-type: application/json');

$uid = trim($_REQUEST['uid']);
$count = 0;
$code = 501;

if ($uid != null) {
    $onlyanime = $_REQUEST['onlyanime'] == 'true' || $_REQUEST['onlyanime'] === true ? true : false;

    $page = 1;
    $request = file_get_contents('http://api.bilibili.com/x/space/bangumi/follow/list?type=1&pn=' . $page . '&ps=30&vmid=' . $uid);
    $request = json_decode($request);

    $judge = count($request->data->list);
    $animeDataAll = array();

    $code = 500;
    while ($judge > 0) {
        $animeDataArr = $request->data->list;
        foreach ($animeDataArr as $value) {
            $count++;
            $areas = ($value->areas)[0]->name;
            if ($onlyanime == true && $areas != '日本') {
                continue;
            }


            $animeData = array(
                'type' => $value->season_type_name,
                'title' => $value->title,
                'subtitle' => $value->subtitle,
                'tags' => $value->styles,
                'descr' => $value->evaluate,
                'cover' => ($value->cover),
                'setnum' => $value->new_ep->index_show,
                'isnew' => $value->isnew ? true : false,
                'showtime' => $value->publish->release_date_show,
                'areas' => $areas,
                'badge' => $value->badge
            );
            array_push($animeDataAll, $animeData);
        }

        $page = $page + 1;
        $request = file_get_contents('http://api.bilibili.com/x/space/bangumi/follow/list?type=1&pn=' . $page . '&ps=30&vmid=' . $uid);
        $request = json_decode($request);

        $judge = count($request->data->list);
    }
}

$errorCode = array(
    500 => 'success',
    501 => 'error'
);

$result = array(
    'code' => $code,
    'message' => $errorCode[$code],
    'data' => array(
        'uid' => intval($uid),
        'count' => $count,
        'list' => $animeDataAll
    )
);

$result = urldecode(json_encode($result, 256));
echo str_replace('\/', '/', $result);
