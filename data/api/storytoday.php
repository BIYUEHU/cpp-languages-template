<?php
header('Content-Type: application/json');

$data = file_get_contents("http://hao.360.com/histoday/");
if ($data == null) {
    die(array(
        'code' => 501,
        'message' => 'error'
    ));
}

preg_match_all('/<\/em>. (.*?)<\/dt>/', $data, $event);
$eventData = array();
for ($int = count($event[1]); $int > 0; $int--) {
    array_push($eventData, $event[1][$int - 1]);
}

$result = array(
    'code' => 500,
    'message' => 'success',
    'data' => $eventData
);
echo stripslashes(json_encode($result, 256));
