<?php
header('Content-Type: text/html');

$n = $_GET["msg"];
$url = "https://www.a9131.com/home/textlist/34/1226-1.html";
$data = file_get_contents($url);
$s = preg_match_all('/<a href=\"(.*?)\" title=\"(.*?)\" target/', $data, $a);
if ($n == null) {
    for ($x = 0; $x < $s && $x <= $s; $x++) {
        $b = $a[2][$x];
        $b = str_replace('0 ', '', $b);
        echo ($x + 1) . ":" . $b . "<br>";
    }
} else {
    $id = $a[1][$n - 1];
    $url = "https://www.a9131.com{$id}";
    $data = file_get_contents($url);
    $s = preg_match_all('/<div class=\"xs-details-content text-xs\">(.*?)<\/div>/', $data, $a);
    $b = $a[1][0];
    $b = str_replace(PHP_EOL, '', $b);
    $b = str_replace(' ', '', $b);
    $b = str_replace(PHP_EOL, '', $b);
    $b = str_replace('  ', '', $b);
    echo $b;
}
