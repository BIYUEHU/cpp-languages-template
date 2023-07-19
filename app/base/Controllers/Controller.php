<?php
/*
 * @Author: Biyuehu biyuehuya@gmail.com
 * @Blog: http://imlolicon.tk
 * @Date: 2023-01-17 13:36:45
 */

namespace Base\Controllers;

use Core\Route;
use Core\Common;
use Lib\Stat;
use function Core\Func\loadConfig;
use function Core\Func\loadView;
use function Core\Func\getUserIp;
use function Core\Func\printJson;

class Controller
{
    // 数据库实体
    public static $db;
    // 公共数据
    public static $data;
    // 地址参数
    protected static $val;
    // 统一状态码列表
    protected static $errorCode;
    protected static $URL = 'http://api.imlolicon.tk/';

    public function __construct()
    {
        //初始化控制器
        self::$errorCode = loadConfig('apicode.php');

        // 实例化数据库
        self::$db = new Common();

        // 获取设置信息
        $web_info = self::getSetData('webinfo');
        define('HULICORE_THEME_PATH', HULICORE_USR_PATH . '/theme/' . $web_info['theme']);

        // 设置公共数据
        self::$data = array(
            "WEB_INFO" => $web_info,
            "WEB_SAFE" => self::getSetData('websafe'),
            "THEME_PATH" => HULICORE_THEME_PATH,
            "THEME_INFO" => loadConfig('_manifest.php', HULICORE_THEME_PATH),
            "THEME_SET" => self::getSetData('theme_' . $web_info['theme']),
            "VERIFY" => null
        );

        // 地址参数
        self::$val = Route::$rulePar;

        // 防XSS攻击 对请求值进行正则判断
        if (Route::$antixss) {
            foreach ($_POST as $val) {
                preg_match_all('/<(.*?)\/?>/', $val, $pregData);
                empty($pregData[0]) || self::printResult(507);
            }
        }

        // 跳过静态资源映射
        if (substr($_SERVER['REQUEST_URI'], 0, 18) != '/index.php/assets/') {
            // 记录日志
            self::logWrite();

            // 验证登录
            self::verifyLogin();
        }
    
        // 跨域请求
        self::$data['WEB_SAFE']['crossdomain'] != 'on' || header('Access-Control-Allow-Origin: *');
    
        // 访客数记录
        if (!isset($_COOKIE['visitor'])) {
            setcookie('visitor', 'ok', time() + 60*60*24*356);
            Stat::WriteTag('web_visitor_' . Stat::StatName, 1, false);
        }

    }


    /**
     * 设置视图自定义数据
     * @param array|string $data
     */
    public static function setViewCustomData($data)
    {
        self::$data['DATA'] = $data;
    }


    /**
     * 打印JSON数据结果
     * @param int $code 状态码,默认500
     * @param array|null $data
     * @param boolean $exit 是否终止运行,默认true
     */
    public static function printResult($code = 500, $data = null, $exit = true)
    {
        if (empty($data)) {
            $result = array(
                "code" => $code,
                "message" => self::$errorCode[$code] ?? 0
            );
        } else {
            $result = array(
                "code" => $code,
                "message" => self::$errorCode[$code] ?? 0,
                "data" => $data
            );
        }
        printJson($result);
        !$exit || exit();
    }


    /**
     * 获取数据库内的设置项数据
     * @param string $set_type 设置类型值
     * @return array 返回键值对数组
     */
    public static function getSetData($set_type) {
        $rows = self::$db->fetchAll(ControllerSetModel, [$set_type]);
        $result = array();
        foreach ($rows as $val) {
            $result[$val['set_key']] = $val['set_val'];
        }
        return $result;
    }


    /**
     * SESSION验证登录
     * @return boolean 是否登录
     */
    public static function verifyLogin()
    {
        if (!empty($_SESSION['hulicore_loginaccount']['email']) && !empty($_SESSION['hulicore_loginaccount']['password'])) {
            $data = self::$db->fetch(HandleUserLoginModel, [$_SESSION['hulicore_loginaccount']['email'], $_SESSION['hulicore_loginaccount']['password']]);
            if (!empty($data)) {
                self::$data['VERIFY'] = $data;
                return $data['opgroup'];
            } else {
                unset($_SESSION['hulicore_loginaccount']);
                return false;
            }
        } else {
            return false;
        }
    }


    /**
     * 验证Apikey
     * @param string $api 接口字符id
     * @param string $apikey Apikey
     * @return boolean|array 有效则返回数据,否则返回false
     */
    public static function verifyApikey($api, $apikey)
    {
        if (!empty($apikey)) {
            $data = self::$db->fetch(ControllerVerifyApikeyModel, [$api, $apikey]);
            return $data['api'] && strtotime($data['ctime']) > time() ? $data : false;
        }
        return false;
    }


    /**
     * 写入网站安全日志
     */
    public function logWrite() {
        return self::$db->exec(ControllerLogWriteModel, [
            $_SERVER['HTTP_USER_AGENT'], $_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD'], getUserIp()
        ]);
    }


    /**
     * 调用次数限制
     */
    public function callLimit() {
        $nowtime = time();
        // 判断SESSION是否被设置以区分是否为第一次访问
        if (isset($_SESSION['callinfo'])) {
            $callInfo = $_SESSION['callinfo'];
            // 当前时间减去记录的初始后最后调用时间(格式均为时间戳)
            $quo = $nowtime - $callInfo['lasttime'];
            if ($quo > self::$data['WEB_SAFE']['cycle']) {
                // 超过时间周期则重置为当前时间并重置调用次数
                $callInfo['lasttime'] = $nowtime;
                $callInfo['num'] = 1;
            } else if ($quo <= self::$data['WEB_SAFE']['cycle'] && $callInfo['num'] > self::$data['WEB_SAFE']['cyclenum']) {
                // 在时间周期内并超过调用次数限制则打印JSON数据结果
                // 传入message提示信息
                self::printResult(510, ['message' => self::$data['WEB_SAFE']['refusemsg']]);
            } else {
                // 在时间周期内但未超过调用次数限制则+1
                $callInfo['num'] = $callInfo['num'] + 1;
            }
        } else {
            // 第一次访问则设置值
            $callInfo['lasttime'] = $nowtime;
            $callInfo['num'] = 1;
        }
        return $_SESSION['callinfo'] = $callInfo;
    }


    /**
     * 载入404错误视图
     */
    public function error404()
    {
        http_response_code(404);
        self::loadView('404.php');
    }


    /**
     * 载入视图(简化大量重复传参用的)
     */
    public function loadView($file) {
        loadView($file, self::$data);
    }


    /* 数据获取公共方法区 */
    /**
     * 获取接口数量数据
     */
    public static function numApiData()
    {
        $bad = count(self::$db->fetchAll(ControllerGetApiINumModel, [0]));
        $well = count(self::$db->fetchAll(ControllerGetApiINumModel, [1]));
        $out = count(self::$db->fetchAll(ControllerGetApiINumModel, [2]));
        $hide = count(self::$db->fetchAll(ControllerGetApiINumModel, [3]));
        $total = $bad + $well + $hide;
        return array(
            "total" => $total,
            "well" => $well,
            "bad" => $bad,
            "out" => $out,
            "hide" => $hide
        );
    }

    /**
     * 获取接口调用数据
     */
    public static function callData()
    {
        return array(
            "total" => Stat::QueryTag('api_call_' . Stat::StatName),
            "today" => Stat::QueryDayTag('api_call_' . Stat::StatName),
            "yesterday" => Stat::QueryDayTag('api_call_' . Stat::StatName, 1),
        );
    }


    /**
     * 获取接口平均调用数据
     */
    public static function callDataAvg($time)
    {
        // 减一下建站时间用来算平均数据
        $cal = (strtotime('today') - strtotime($time)) / 86400;

        $callData = Stat::QueryTag('api_call_' . Stat::StatName);
        return array(
            "mouth" => floor($callData / $cal * 12),
            "week" => floor($callData / $cal * 7),
            "day" => floor($callData / $cal),
            "hour" => floor($callData / $cal / 24)
        );
    }


    /**
     * 获取网站访问数据
     */
    public static function visitWebData()
    {
        return array(
            "total" => Stat::QueryTag('web_visit_' . Stat::StatName),
            "today" => Stat::QueryDayTag('web_visit_' . Stat::StatName),
            "yesterday" => Stat::QueryDayTag('web_visit_' . Stat::StatName, 1)
        );
    }


    /**
     * 获取网站访客数据
     *
     */
    public static function visitorWebData()
    {
        return array(
            "total" => Stat::QueryTag('web_visitor_' . Stat::StatName),
            "today" => Stat::QueryDayTag('web_visitor_' . Stat::StatName),
            "yesterday" => Stat::QueryDayTag('web_visitor_' . Stat::StatName, 1)
        );
    }


    /**
     * 获取子站数据
     *
     */
    public static function childSiteData()
    {
        if (file_exists(HULICORE_BASE_CONTROLLER_PATH . '/Site/IndexController.php')) {
            $siteData = self::$db->fetchAll(HandleAdminAccountModel);
            $website = [];
            foreach($siteData as $val) {
                empty($val['website']) || array_push($website, $val['website']);
            }
            return array(
                "num" => count($website),
                "list" => $website
            );
        }
        return null;
    }

}
