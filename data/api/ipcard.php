<?php
/*
 * @Author: Biyuehu biyuehuya@gmail.com
 * @Blog: http://imlolicon.tk
 * @Date: 2023-06-26 11:43:06
 */
function getBrowser()
{
    $sys = $_SERVER['HTTP_USER_AGENT'];  //获取用户代理字符串
    if (stripos($sys, "Firefox/") > 0) {
        preg_match("/Firefox\/([^;)]+)+/i", $sys, $b);
        $exp[0] = "Firefox";
        $exp[1] = $b[1];  //获取火狐浏览器的版本号
    } elseif (stripos($sys, "Maxthon") > 0) {
        preg_match("/Maxthon\/([\d\.]+)/", $sys, $aoyou);
        $exp[0] = "Maxthon";
        $exp[1] = $aoyou[1];
    } elseif (stripos($sys, "MSIE") > 0) {
        preg_match("/MSIE\s+([^;)]+)+/i", $sys, $ie);
        $exp[0] = "IE";
        $exp[1] = $ie[1];  //获取IE的版本号  
    } elseif (stripos($sys, "OPR") > 0) {
        preg_match("/OPR\/([\d\.]+)/", $sys, $opera);
        $exp[0] = "Opera";
        $exp[1] = $opera[1];
    } elseif (stripos($sys, "Edge") > 0) {
        //win10 Edge浏览器 添加了chrome内核标记 在判断Chrome之前匹配
        preg_match("/Edge\/([\d\.]+)/", $sys, $Edge);
        $exp[0] = "Edge";
        $exp[1] = $Edge[1];
    } elseif (stripos($sys, "Chrome") > 0) {
        preg_match("/Chrome\/([\d\.]+)/", $sys, $google);
        $exp[0] = "Chrome";
        $exp[1] = $google[1];  //获取google chrome的版本号  
    } elseif (stripos($sys, 'rv:') > 0 && stripos($sys, 'Gecko') > 0) {
        preg_match("/rv:([\d\.]+)/", $sys, $IE);
        $exp[0] = "IE";
        $exp[1] = $IE[1];
    } else {
        $exp[0] = "unknown";
        $exp[1] = "";
    }
    return $exp[0] . '(' . $exp[1] . ')';
}

function getOs()
{
    $agent = $_SERVER['HTTP_USER_AGENT'];
    $os = false;

    if (preg_match('/win/i', $agent) && strpos($agent, '95')) {
        $os = 'Windows 95';
    } else if (preg_match('/win 9x/i', $agent) && strpos($agent, '4.90')) {
        $os = 'Windows ME';
    } else if (preg_match('/win/i', $agent) && preg_match('/98/i', $agent)) {
        $os = 'Windows 98';
    } else if (preg_match('/win/i', $agent) && preg_match('/nt 6.0/i', $agent)) {
        $os = 'Windows Vista';
    } else if (preg_match('/win/i', $agent) && preg_match('/nt 6.1/i', $agent)) {
        $os = 'Windows 7';
    } else if (preg_match('/win/i', $agent) && preg_match('/nt 6.2/i', $agent)) {
        $os = 'Windows 8';
    } else if (preg_match('/win/i', $agent) && preg_match('/nt 10.0/i', $agent)) {
        $os = 'Windows 10'; #添加win10判断  
    } else if (preg_match('/win/i', $agent) && preg_match('/nt 5.1/i', $agent)) {
        $os = 'Windows XP';
    } else if (preg_match('/win/i', $agent) && preg_match('/nt 5/i', $agent)) {
        $os = 'Windows 2000';
    } else if (preg_match('/win/i', $agent) && preg_match('/nt/i', $agent)) {
        $os = 'Windows NT';
    } else if (preg_match('/win/i', $agent) && preg_match('/32/i', $agent)) {
        $os = 'Windows 32';
    } else if (preg_match('/linux/i', $agent)) {
        $os = 'Linux';
        if (preg_match('/Android.([0-9. _]+)/i', $agent, $matches)) {
            $os = 'Android';
        } elseif (preg_match('#Ubuntu#i', $agent)) {
            $os = 'Ubuntu';
        } elseif (preg_match('#Debian#i', $agent)) {
            $os = 'Debian';
        } elseif (preg_match('#Fedora#i', $agent)) {
            $os = 'Fedora';
        }
    } else if (preg_match('/unix/i', $agent)) {
        $os = 'Unix';
    } else if (preg_match('/sun/i', $agent) && preg_match('/os/i', $agent)) {
        $os = 'SunOS';
    } else if (preg_match('/ibm/i', $agent) && preg_match('/os/i', $agent)) {
        $os = 'IBM OS/2';
    } else if (preg_match('/Mac/i', $agent) && preg_match('/PC/i', $agent)) {
        $os = 'Macintosh';
    } else if (preg_match('/PowerPC/i', $agent)) {
        $os = 'PowerPC';
    } else if (preg_match('/AIX/i', $agent)) {
        $os = 'AIX';
    } else if (preg_match('/HPUX/i', $agent)) {
        $os = 'HPUX';
    } else if (preg_match('/NetBSD/i', $agent)) {
        $os = 'NetBSD';
    } else if (preg_match('/BSD/i', $agent)) {
        $os = 'BSD';
    } else if (preg_match('/OSF1/i', $agent)) {
        $os = 'OSF1';
    } else if (preg_match('/IRIX/i', $agent)) {
        $os = 'IRIX';
    } else if (preg_match('/FreeBSD/i', $agent)) {
        $os = 'FreeBSD';
    } else if (preg_match('/teleport/i', $agent)) {
        $os = 'teleport';
    } else if (preg_match('/flashget/i', $agent)) {
        $os = 'flashget';
    } else if (preg_match('/webzip/i', $agent)) {
        $os = 'webzip';
    } else if (preg_match('/offline/i', $agent)) {
        $os = 'offline';
    } else {
        $os = 'unknown';
    }
    return $os;
}


header("Content-type: image/jpeg");

$imgNum = intval($_GET['img']);
$imgNum = empty($_GET['img']) || $imgNum < 1 || $imgNum > 11 ? rand(1, 11) : $imgNum;
$imgList = ['', 'Nagisa', 'Chino', 'Kanade', 'Atri', 'Kotori', 'Mashiro', 'Miku', 'Reimu', 'Rin', 'Saber', 'Mitsuha',
];
$img = imagecreatefromjpeg(__DIR__ . '/res/ipcard/' . $imgList[$imgNum] . ".jpg");

$ip = $_GET['ip'] ?? $_SERVER["REMOTE_ADDR"];
$city = json_decode(file_get_contents("http://opendata.baidu.com/api.php?query={$ip}&co=&resource_id=6006&oe=utf8"), 256)['data'][0]['location'];

// 独立什么的最好きです了
// 小pink们别急🤣🤣🤣🤣
if ($city == '台湾省' || strstr($city, '台湾')) $city = '中华民国';
if ($city == '香港特别行政区' || strstr($city, '香港')) $city = '英属香港';
if ($city == '澳门特别行政区' || strstr($city, '澳门')) $city = '葡属澳门';
if (strstr($city, '新疆')) $city = '东突厥斯坦伊斯兰共和国';
if (strstr($city, '内蒙古')) $city = '南蒙古国';
if (strstr($city, '西藏')) $city = '西藏喜乐宫胜十方政府';
// 这个面子必须给
if ($city == '日本') $city = '家乡';

$weekArray = ["日曜日", "月曜日", "火曜日", "水曜日", "木曜日", "金曜日", "土曜日"];

//定义颜色
$black = ImageColorAllocate($img, 0, 0, 0); //定义黑色的值
$black2 = ImageColorAllocate($img, 0, 0, 5); //红色
$font = __DIR__ . '/res/font.ttf'; //加载字体

//输出
imagettftext($img, 14, 0, 40, 40, $black, $font, 'とし: ' . $city . '');
imagettftext($img, 14, 0, 40, 72, $black, $font, date('Y') . '年' . date('m') . '月' . date('d') . '日 ' . $weekArray[date("w")]); //当前时间添加到图片
imagettftext($img, 14, 0, 40, 104, $black, $font, 'IP: ' . $ip); //ip
imagettftext($img, 14, 0, 40, 140, $black, $font, 'システム: ' . getOs() . '');
imagettftext($img, 14, 0, 40, 175, $black, $font, 'エクスプローラ: ' . getBrowser());
imagettftext($img, 12, 0, 330, 200, $black2, $font, '-HULICore By Biyuehu');
ImageGif($img);
ImageDestroy($img);
