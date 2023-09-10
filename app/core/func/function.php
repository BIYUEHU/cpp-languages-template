<?php
/*
 * @Author: Biyuehu biyuehuya@gmail.com
 * @Blog: http://hotaru.icu
 * @Date: 2023-01-17 13:36:45
 */

namespace Core\Func;

use function Base\Controllers\statement;

function send_post($url, $data = null)
{
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($curl);
    return $response;
}

function get_url($url, $cookie = false)
{
    $url = parse_url($url);
    $query = $url['path'] . "?" . $url['query'];
    echo "Query:" . $query;
    $fp = fsockopen($url['host'], $url['port'] ? $url['port'] : 80, $errno, $errstr, 30);
    if (!$fp) {
        return false;
    } else {
        $request = "GET $query HTTP/1.1rn";
        $request .= "Host: $url[host]rn";
        $request .= "Connection: Closern";
        if ($cookie) $request .= "Cookie:  $cookie";
        $request .= "rn";
        fwrite($fp, $request);
        $result = '';
        while (!@feof($fp)) {
            $result .= @fgets($fp, 1024);
        }
        fclose($fp);
        return $result;
    }
}

//获取url的html部分，去掉header
function GetUrlHTML($url, $cookie = false)
{
    $rowdata = get_url($url, $cookie);
    if ($rowdata) {
        $body = stristr($rowdata, "rnrn");
        $body = substr($body, 4, strlen($body));
        return $body;
    }

    return false;
}

/**
 * 加载视图
 * @param string $file 文件名
 * @param array $data 待映射到视图的数据
 * @param string $path 根目录
 */
function loadView($file, $data = [], $path = HULICORE_THEME_PATH)
{
    foreach ($data as $key => $value) {
        $$key = $value;
    }
    $path = $path . '/' . $file;
    if (file_exists($path)) {
        require($path);
        statement();
    } else {
        printDebug($path . 'VIEW不存在');
        exit();
    }
}


/**
 * 加载配置
 * @param string $file 文件名字
 * @param string $path 根目录
 */
function loadConfig($file, $path = HULICORE_CONFIG_PATH)
{
    $path = $path . '/' . $file;
    if (file_exists($path)) {
        $result = require($path);
        if (gettype($result) == 'array') {
            return $result;
        } else {
            printDebug($path . 'CONFIG格式错误');
            exit();
        }
    } else {
        printDebug($path . 'CONFIG不存在');
        exit();
    }
}


/**
 * 设置配置
 * @param array $data 配置数据数组
 * @param string $file 文件名字
 * @param string $path 根目录
 */
function setConfig($data, $file, $path = HULICORE_CONFIG_PATH)
{
    $path = $path . '/' . $file;
    $data = stripslashes(urldecode(json_encode($data, JSON_PRETTY_PRINT | 256)));
    $result = "<?php
return {$data};
";
    return file_put_contents($path, $result);
}


/**
 * 打印JSON数据
 * @param array $data JSON数据
 */
function printJson($data)
{
    header("content-type:application/json");
    $result = urldecode(json_encode($data, 256));
    echo str_replace('\/', '/', $result);
}


/**
 * 跳转页面
 * @param string $url 链接
 */
function location($url)
{
    header("location: {$url}");
}


/**
 * 获取UUID
 * @return string
 */
function getUuid()
{
    $chars = md5(uniqid(mt_rand(), true));
    $uuid = substr($chars, 0, 8) . '-'
        . substr($chars, 8, 4) . '-'
        . substr($chars, 12, 4) . '-'
        . substr($chars, 16, 4) . '-'
        . substr($chars, 20, 12);
    return $uuid;
}


/**
 * 获取KEY
 * @return string
 */
function getKey()
{
    $chars = md5(uniqid(mt_rand(), true));
    $key = substr($chars, 0, 8)
        . substr($chars, 8, 4)
        . substr($chars, 12, 4)
        . substr($chars, 16, 4)
        . substr($chars, 20, 12);
    return $key;
}


/**
 * 获取用户IP
 * @return bool|string
 */
function getUserIp()
{
    if (isset($_SERVER)) {
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && strcasecmp($_SERVER['HTTP_X_FORWARDED_FOR'], "unknown")) { //代理
            $realip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } elseif (isset($_SERVER['HTTP_CLIENT_IP']) && strcasecmp($_SERVER['HTTP_CLIENT_IP'], "unknown")) {
            $realip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (isset($_SERVER['REMOTE_ADDR']) && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown")) {
            $realip = $_SERVER['REMOTE_ADDR'];
        } else {
            $realip = 'unknown';
        }
    } else {
        if (getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown")) {
            $realip = getenv("HTTP_X_FORWARDED_FOR");
        } elseif (getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"), "unknown")) {
            $realip = getenv("HTTP_CLIENT_IP");
        } elseif (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown")) {
            $realip = getenv("REMOTE_ADDR");
        } else {
            $realip = 'unknown';
        }
    }
    return $realip;
}


/**
 * 获取用户浏览器信息
 * @param string UA标识 默认当前UA
 * @return string
 */
function getUserBrowser($sys = null)
{
    !empty($sys) || $sys = $_SERVER['HTTP_USER_AGENT'];
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


/**
 * 获取用户系统信息
 * @param string UA标识 默认当前UA
 * @return string
 */
function getUserOs($agent = null)
{
    !empty($agent) || $agent = $_SERVER['HTTP_USER_AGENT'];
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


/**
 * 输出前端日志
 * @param string $message
 */
function consolelog($message)
{
    echo '<script type="text/javascript">console.log(' . $message . ');</script>';
}


/**
 * 删除当前目录及其目录下的所有目录和文件
 * @param string $path 待删除的目录
 * @note  $path路径结尾不要有斜杠/(例如:正确[$path='./static/image'],错误[$path='./static/image/'])
 */
function deleteDir($path)
{
    if (is_dir($path)) {
        $dirs = scandir($path);
        foreach ($dirs as $dir) {
            if ($dir != '.' && $dir != '..') {
                $sonDir = $path . '/' . $dir;
                if (is_dir($sonDir)) {
                    deleteDir($sonDir);
                    @rmdir($sonDir);
                } else {
                    @unlink($sonDir);
                }
            }
        }
        @rmdir($path);
    }
}


/**
 * 获取目录下的第一层所有文件夹名字
 * @param string $dir 目录
 * @return array|boolean
 */
function getAllDirs($dir)
{
    $files = [];
    if (is_dir($dir)) {
        if ($handle = opendir($dir)) {   //打开目录句柄
            while (($file = readdir($handle)) !== false) {   //循环遍历目录
                !(is_dir($dir . "/" . $file) && $file != '.' && $file != '..') || array_push($files, $file);
            }
            return $files;
        }
        closedir($handle);
    }
    return false;
}


/**
 * 获取目录下的第一层所有文件名字
 * @param string $dir 目录
 * @return array
 */
function getAllFiles($dir)
{
    $handle = opendir($dir);
    $i = 0;
    while (!!$file = readdir($handle)) {
        if (($file != ".") and ($file != "..")) {
            $list[$i] = $file;
            $i = $i + 1;
        }
    }
    closedir($handle);
    return $list;
}


/**
 * 正则搜索
 * @param string $value 待匹配字符串
 * @param string $key 正则
 * @return string 匹配返回数据否则返回false
 */
function matchSearch($value, $key)
{
    preg_match_all($key, $value, $data);
    return empty($data[0]) ? false : $data;
}


/**
 * Debug输出
 * @param string $message 内容
 */
function printDebug($message)
{
    if (HULICORE_SET_DEBUG == 'ON') {
        switch (HULICORE_SET_DEBUG_MODE) {
            case 'print':
                print($message);
                break;
            case 'print_r':
                print_r($message);
                break;
            case 'printf':
                printf($message);
                break;
            case 'var_dump':
                var_dump($message);
                break;
            case 'console':
                consolelog('`' . $message . '`');
                break;
            default:
                echo ($message);
        }
    }
}
