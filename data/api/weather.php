<?php
header('Content-Type: text/plain');

function jiequ($txt1, $q1, $h1)
{
    $txt1 = strstr($txt1, $q1);
    $cd = strlen($q1);
    $txt1 = substr($txt1, $cd);
    $txt1 = strstr($txt1, $h1, true);
    return $txt1;
}
$msg = $_REQUEST['msg'];
$b = $_REQUEST['b'];
$list = file_get_contents("http://m.moji.com/api/citysearch/" . $msg);
$result = preg_match_all("/{\"cityId\":(.*?),\"city_lable\":(.*?),\"counname\":\"(.*?)\",\"id\":(.*?),\"localCounname\":\"(.*?)\",\"localName\":\"(.*?)\",\"localPname\":\"(.*?)\",\"name\":\"(.*?)\",\"pname\":\"(.*?)\"}/", $list, $nute);
if ($b == null) {
    for ($x = 0; $x < $result && $x <= 9; $x++) {
        $jec = $nute[6][$x];
        $je = $nute[7][$x];
        echo ($x + 1) . "：" . $je . "-" . $jec . "\n";
    }
    echo "提示：发送以上序号选择，例：选墨迹天气 1";
} else
if ($b > 10 || $b < 1) {
    echo "请按以上序号选择";
} else {
    $b = $_REQUEST['b'];
    $b = ($b - 1);
    $je = $nute[1][$b];
    $jec = $nute[6][$b];
    $lis = file_get_contents("http://m.moji.com/api/redirect/" . $je);
    $bb = jiequ($lis, "<div class=\"weak_wea\">", "<div class=\"exponent\">");
    $bb = str_replace(' ', '', $bb);
    preg_match_all("/<lidata-high=\"(.*?)\"data-low=\"(.*?)\">/", $bb, $aa);
    preg_match_all("/<em>(.*?)<\/em>/", $bb, $qq);
    preg_match_all("/<dd><strong>(.*?)<\/strong><\/dd>/", $bb, $cc);
    preg_match_all("/<pclass=\"(.*?)\">(.*?)<\/p><dlclass=\"wind\">/", $bb, $dd);
    preg_match_all("/<dd>(.*?)<\/dd>/", $bb, $ee);
    preg_match_all("/<dd>(.*?)<\/dd>/", $bb, $ff);
    echo "城市：" . $jec . "\n";
    echo "日期：" . $qq[1][0] . "\n";
    echo "温度：" . $aa[2][0] . "～" . $aa[1][0] . "℃\n";
    echo "天气：" . $cc[1][0] . "\n";
    echo "风度：" . $ee[1][2] . "-" . $ff[1][3] . "\n";
    echo "空气质量：" . $dd[2][0] . "\n";
    echo "\n";
    echo "日期：" . $qq[1][1] . "\n";
    echo "温度：" . $aa[2][1] . "～" . $aa[1][1] . "℃\n";
    echo "天气：" . $cc[1][1] . "\n";
    echo "风度：" . $ee[1][6] . "-" . $ff[1][7] . "\n";
    echo "空气质量：" . $dd[2][1] . "\n";
    echo "\n";
    echo "日期：" . $qq[1][2] . "\n";
    echo "温度：" . $aa[2][2] . "～" . $aa[1][2] . "℃\n";
    echo "天气：" . $cc[1][2] . "\n";
    echo "风度：" . $ee[1][10] . "-" . $ff[1][11] . "\n";
    echo "空气质量：" . $dd[2][2] . "";
}
