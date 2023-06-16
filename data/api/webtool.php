<?php
header('Content-Type: text/html');

$op = intval(trim($_GET['op']));
$url = trim($_GET['url']);

if ($op == null && $url == null) {
    $_result =  "菜单:<br>
1.状态查询<br>
2.域名查询(维护)<br>
3.网站测速<br>
4.ping(维护)<br>
5.收录查询(维护)<br>
6.收录量查询(维护)<br>
请发送数字<br>";
} else if ($op != null && $url == null) {
    $_result = "请输入URL";
} else if ($op != null && $url != null) {
    switch ($op) {
        case 1:
            $status = array(
                "100" => "继续]请求者应当继续提出请求。服务器返回此代码表示已收到请求的第一部分，正在等待其余部分。 ",
                "101" => "切换协议]请求者已要求服务器切换协议，服务器已确认并准备切换。",
                "200" => "成功",
                "201" => "已创建",
                "202" => "已接受",
                "203" => "非授权信息",
                "204" => "无内容",
                "205" => "重置内容",
                "206" => "部分内容",
                "300" => "多种选择",
                "301" => "永久移动",
                "302" => "临时移动",
                "303" => "查看其他位置",
                "304" => "未修改",
                "305" => "使用代理",
                "307" => "临时重定向",
                "400" => "错误请求",
                "401" => "未授权",
                "403" => "禁止",
                "404" => "未找到",
                "405" => "方法禁用",
                "406" => "不接受",
                "407" => '[需要代理授权',
                "408" => "请求超时",
                "409" => "冲突",
                "410" => "已删除",
                "411" => "需要有效长度",
                "412" => "未满足前提条件",
                "413" => "请求实体过大",
                "414" => "请求的URI过长",
                "415" => "不支持的媒体类型",
                "416" => "请求范围不符合要求",
                "417" => '未满足期望值',
                "500" => "服务器内部错误",
                "501" => "尚未实施",
                "502" => "错误网关",
                "503" => "服务不可用",
                "504" => "网关超时",
                "505" => "HTTP版本不受支持",
            );
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_TIMEOUT, 200);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
            curl_setopt($ch, CURLOPT_HEADER, FALSE);
            curl_setopt($ch, CURLOPT_NOBODY, FALSE);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, FALSE);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
            curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            if ($status[$httpCode]) {
                echo "" . $ming . "域名/IP:" . $url . "<br>状态:" . $httpCode . "<br>解释:" . $status[$httpCode];
            } else {
                echo "" . $ming . "域名:" . $url . "<br>未知的HTTP状态!";
            }
            break;
        case 2:
            // error_reporting(0);
            if (strstr($_REQUEST['url'], "http")) {
                preg_match('/(http|https):\/\/([\w\d\-_]+[\.\w\d\-_]+)[:\d+]?([\/]?[\w\/\.]+)/i', $_REQUEST['url'], $url);
            } else {
                preg_match('/([\w\d\-_]+[\.\w\d\-_]+)[:\d+]?([\/]?[\w\/\.]+)/i', $_REQUEST['url'], $url);
            }
            $url = str_replace(array("http://", "https://"), "", $url[0]);
            if ($url == null) {
                echo "请输入域名！";
                exit();
            }
            $url = str_replace("http://", "", $url);
            $url = str_replace("https://", "", $url);
            $url = "http://" . $url;
            $urll = "https://whois.chinaz.com/" . getTopHost($url);
            //$urll="https://mwhois.chinaz.com/".getTopHost($url);
            $curl = curl_init();
            $httpheader[] = "Accept:*/*";
            $httpheader[] = "Accept-Language:zh-CN,zh;q=0.8";
            $httpheader[] = "Connection:close";
            $httpheader[] = "Referer:http://whois.chinaz.com";
            $httpheader[] = "User-agent:Mozilla/5.0 (iPhone; CPU iPhone OS 5_1 like Mac OS X) AppleWebKit/534.46 (KHTML,like Gecko) Mobile/9B176 MicroMessenger/4.3.2";
            curl_setopt($curl, CURLOPT_HTTPHEADER, $httpheader);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_TIMEOUT, 60);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($curl, CURLOPT_URL, $urll);
            $text = curl_exec($curl);
            curl_close($curl);
            preg_match('/注册商<\/div><div class="fr WhLeList-right"><div class="block ball"><span>(.*?)<\/span>/i', $text, $zhuceshang);
            preg_match('/联系人<\/div><div class="fr WhLeList-right block ball lh24"><span>(.*?)<\/span>/i', $text, $contacts);
            preg_match('/创建时间<\/div><div class="fr WhLeList-right"><span>(.*?)<\/span>/i', $text, $chuangjianshijian);
            preg_match('/过期时间<\/div><div class="fr WhLeList-right"><span>(.*?)<\/span>/i', $text, $guoqishijian);
            preg_match('/DNS<\/div><div class="fr WhLeList-right">(.*?)<br\/><\/div>/i', $text, $dns);
            preg_match('/联系电话<\/div><div class="fr WhLeList-right block ball lh24"><span>(.*?)<\/span>/i', $text, $phone);
            preg_match('/公司<\/div><div class="fr WhLeList-right"><div class="block ball"><span>(.*?)<\/span>/i', $text, $gongsi);
            preg_match('/<div class="fl WhLeList-left">联系邮箱<\/div><div class="fr WhLeList-right block ball lh24"><span>(.*?)<\/span>/i', $text, $mail);
            $dnsarray = explode("<br/>", $dns[1]);
            if (!empty($gongsi[1])) {
                $gongsi = $gongsi[1];
            } else {
                $gongsi = '无';
            }
            if (!empty($phone[1])) {
                $phone = $phone[1];
            } else {
                $phone = '无';
            }
            if (!empty($zhuceshang[1])) {
                $zhuceshang = $zhuceshang[1];
            } else {
                $zhuceshang = '查询失败';
            }
            if ($dnsarray[0] == null) {
                echo "域名信息获取失败!";
                exit();
            }
            $url = str_replace("http://", "", $url);
            $url = str_replace("https://", "", $url);
            echo "查询信息域名:" . $url . "\n注册商:" . $zhuceshang . "\n联系人:" . $contacts[1] . "\n公司:" . $gongsi . "\n邮箱:" . $mail[1] . "\n电话:" . $phone . "\n创建时间:" . $chuangjianshijian[1] . "\n过期时间:" . $guoqishijian[1] . "\nDNS:" . $dnsarray[0] . "," . $dnsarray[1] . "";
            function getTopHost($url)
            {
                $url = strtolower($url);
                $hosts = parse_url($url);
                $host = $hosts['host'];
                $data = explode('.', $host);
                $n = count($data);
                $preg = '/[\w].+\.(com|net|org|gov|edu)\.cn$/';
                if (($n > 2) && preg_match($preg, $host)) {
                    $host = $data[$n - 3] . '.' . $data[$n - 2] . '.' . $data[$n - 1];
                } else {
                    $host = $data[$n - 2] . '.' . $data[$n - 1];
                }
                return $host;
            }
            break;
        case 3:
            if (preg_match('/http:\/\//i', $_GET['url']) | preg_match('/https:\/\//i', $_GET['url'])) {
                $_result =  '不能带http://或https://，只需要输入域名！';
            } else {
                $msg = $_GET['url'];
                $host = $msg;
                $port = '80';
                $num = 2; //Ping次数
                $tip = gethostbyname($_GET['url']);
                // $bip = file_get_contents("http://49.234.72.124:88/ip.php?ip=".$tip);
                //获取时间

                function mt_f()
                {
                    list($usec, $sec) = explode(" ", microtime());
                    return ((float)$usec + (float)$sec); //微秒加秒
                }

                function ping_f($host, $port)
                {
                    $time_s = mt_f();
                    $ip = gethostbyname($host);
                    $fp = @fsockopen($host, $port);
                    if (!$fp)
                        return '测试超时';
                    $get = "GET / HTTP/1.1\r<br>Host:" . $host . "\r<br>Connect:" . $port . "Close\r<br>";
                    fputs($fp, $get);
                    fclose($fp);
                    $time_e = mt_f();
                    $time = $time_e - $time_s;
                    $time = ceil($time * 1000);
                    return $time;
                }
                if (ping_f($host, $port) == '测试超时') {
                    echo '测试超，请检查目标站点是否正常！';
                } else {
                    for ($i = 0; $i < $num; $i++) {
                        if ($i == 0) {
                            $s1 = $t . ping_f($host, $port);
                        } elseif ($i == 1) {
                            $s2 = $t . ping_f($host, $port);
                        }
                        //每次运行中间间隔1S
                        sleep(1);
                        //刷新输出缓存
                        ob_flush();
                        flush();
                    }
                    if ($s1 > $s2) {
                        echo '最慢：' . $s1 . "/ms<br>最快：" . $s2 . "/ms<br>平均：" . (($s1 - $s2) / 2 + $s2) . "/ms<br>响应IP：" . $tip;
                    } else {
                        echo '最慢：' . $s2 . "/ms<br>最快：" . $s1 . "/ms<br>平均：" . (($s2 - $s1) / 2 + $s1) . "/ms<br>响应IP：" . $tip;
                    }
                }
            }
            break;
        case "4":
            $_result = '该功能维护中';
            break;
        case "5":
            $_result = '该功能维护中';
            break;
        case "6":
            $_result = '该功能维护中';
            break;
        default:
            $_result = '未知的参数';
    }
} else {
    $_result = '未知的错误';
}
echo $_result;
