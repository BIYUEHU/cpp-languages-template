<?php
class Tieba
{
    public static function search($word, $page = 1)
    {
        $pn = ($page - 1) * 10;

        $url = 'http://tieba.baidu.com/mo/m?word=' . $word . '&tn=bdPSW&pn=' . $pn . '&sub5=%E6%90%9C%E4%BD%9C%E8%80%85';
        $data = self::get_curl($url);

        if (preg_match('/建议您检查输入作者名有无错误/', $data)) {
            return;
        }

        preg_match_all('!<div class="i">(.*?)</div>!is', $data, $matchs);
        $data = [];
        foreach ($matchs[1] as $val) {
            $valex = explode("<br/>", $val);
            preg_match('/"(.*)?"/', $valex[0], $match1);
            preg_match('/>(.*)?</', $valex[0], $match2);
            preg_match('/(.*)?">(.*)?<\/a>/', $valex[2], $match3);
            preg_match('/;<span class="b">(.*)?<\/span>/', $valex[2], $match4);
            array_push($data, array(
                "title" => $match2[1],
                "content" => $valex[1],
                "group" => $match3[2] . "吧",
                "time" => $match4[1],
                "url" => "https://tieba.baidu.com" . $match1[1]
            ));
        }
        return $data;
    }

    private static function get_curl($url, $post = 0, $referer = 0, $cookie = 0, $header = 0, $ua = 0, $nobaody = 0)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $httpheader[] = "Accept:*/*";
        $httpheader[] = "Accept-Encoding:gzip,deflate,sdch";
        $httpheader[] = "Accept-Language:zh-CN,zh;q=0.8";
        $httpheader[] = "Connection:close";
        curl_setopt($ch, CURLOPT_HTTPHEADER, $httpheader);
        if ($post) {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        }
        if ($header) {
            curl_setopt($ch, CURLOPT_HEADER, true);
        }
        if ($cookie) {
            curl_setopt($ch, CURLOPT_COOKIE, $cookie);
        }
        if ($referer) {
            if ($referer == 1) {
                curl_setopt($ch, CURLOPT_REFERER, 'http://tieba.baidu.com/');
            } else {
                curl_setopt($ch, CURLOPT_REFERER, $referer);
            }
        }
        if ($ua) {
            curl_setopt($ch, CURLOPT_USERAGENT, $ua);
        } else {
            curl_setopt($ch, CURLOPT_USERAGENT, "MQQBrowser/Mini3.1 (Nokia3050/MIDP2.0)");
        }
        if ($nobaody) {
            curl_setopt($ch, CURLOPT_NOBODY, 1);
        }
        curl_setopt($ch, CURLOPT_ENCODING, "gzip");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $ret = curl_exec($ch);
        curl_close($ch);
        return $ret;
    }
}

header('Content-type: application/json');
$name = $_REQUEST['name'];
$page = $_REQUEST['page'];
$codelist = \Core\Func\loadConfig('apicode.php');
$code = 501;
$data = [];
if (!empty($name)) {
    $data = Tieba::search($_REQUEST['name'], $page);
    $code = empty($data) ? 502 : 500;
}
echo json_encode(array(
    "code" => $code,
    "message" => $codelist[$code],
    "data" => $data
), 256);
