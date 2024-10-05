<?php
header('Content-Type: application/json');

function handelStr($str)
{
    // $str = str_replace(' ', "", $str);
    $str = str_replace("\n", "", $str);
    $str = str_replace("\t", "", $str);
    $str = str_replace("\r", "", $str);
    return $str;
}

function containsEnglishLetter($str) {
    return ;
}

$format = $_REQUEST['format'];
$type = $_REQUEST['type'];

$file = file(__DIR__ . '/res/words/' . ce . '.txt');
$fileCount = count($file);
$rand = rand(1, $fileCount);

$text = handelStr($file[$rand], 256);

if (preg_match('/[a-zA-Z]/', $text)) {
    $english = $text;
    $zhinese = handelStr($file[$rand - 1], 256);
} else {
    $english = handelStr($file[$rand + 1], 256);
    $zhinese = $text;
}

$text = $english . "\n" . $zhinese;

if ($format == 'text') {
    header('Content-type: text/plain');
    if ($type == 'english') echo $english;
    else if ($type == 'zhinese') echo $zhinese;
    else echo $text;
} else {
    $result = array(
        'code' => 500,
        'message' => 'success',
        'data' => array(
            'text' => $text,
            'english' => $english,
            'zhinese' => $zhinese
        )
    );

    echo json_encode($result, 256);
}