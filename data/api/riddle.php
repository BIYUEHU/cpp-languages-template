<?php
header('Content-Type: application/json');

$html = file_get_contents(__DIR__ . "/res/riddle.txt");
$result = preg_match_all('/topic":"(.*?)",answer":"(.*?)",type":"(.*?)",ps":"(.*?)"/', $html, $arr);

$arrr = range(0, $result);
shuffle($arrr);
foreach ($arrr as $values);

$result = array(
    'code' => 500,
    'message' => 'success',
    'data' => array(
        'topic' => $arr[1][$values],
        'answer' => $arr[2][$values],
        'type' => $arr[3][$values],
        'ps' => $arr[4][$values]
    )
);
echo stripslashes(urldecode(json_encode($result, 256)));
