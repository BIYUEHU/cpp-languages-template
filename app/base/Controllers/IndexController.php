<?php
/*
 * @Author: Biyuehu biyuehuya@gmail.com
 * @Blog: http://imlolicon.tk
 * @Date: 2023-06-16 14:20:19
 */

namespace Base\Controllers;

use Lib\Stat;
use function Core\Func\loadConfig;
use function Core\Func\loadView;
use function Core\Func\location;

class IndexController extends Controller
{
    /* 主页相关 */
    public function index()
    {
        if (loadConfig('theme.php')['type'] != 'HotaruCore') {
            $data = file_get_contents(self::$URL . 'site/info?website=' . $_SERVER['HTTP_HOST']);
            json_decode($data)->code == 500 || location('/help.html');
        }
        
        // 计入网站访问统计
        Stat::WriteTag('web_visit_' . Stat::StatName, 1, false);

        /*         $data = [
            [
                'numApi' => self::numApiData(),
                'call' => self::callData(),
                'visit' => self::visitWebData(),
                'visitor' => self::visitWebData()
            ],
            self::$db->fetchAll(PageIndexModel)
        ]; */
        $data = self::$db->fetchAll(PageIndexModel);
        self::setViewCustomData($data);

        self::loadView('index.php');
    }

    public function log()
    {
        self::loadView('log.php');
    }

    public function friends()
    {
        self::loadView('friends.php');
    }

    public function jumpto()
    {
        self::$data['DATA'] = ['url' => $_GET['url']];
        self::loadView('jumpto.php');
    }

    public function about()
    {
        self::loadView('about.php');
    }


    /* 文档入口 */
    public function doc()
    {
        $row = self::$db->fetch(PageDocModel, [self::$val]);

        // 判断接口数据是否存在于数据库
        if (!empty($row['idstr'])) {
            $state = $row['state'];

            // 条件:状态为0(接口维护) 且 当前未登录(管理员可绕过维护状态进行接口测试)
            $state == 0 && !self::verifyLogin() && exit(loadView('badApi.html', [], HULICORE_BASE_VIEW_PATH));

            $row['returnTemp'] = handleReturnType($row['returnType'], $row['returnTemp']);
            $row['codeTemp'] = handleCodeTemp($row['returnType']) ?? '';

            $row['returnParHtml'] = renderParTable(handleParStr($row['returnPar']), 3);
            $row['requestParHtml'] = renderParTable(handleParStr($row['requestPar']), 4);
            $row['codeParHtml'] = renderParTable(handleParStr($row['codePar']), 2);

            // 调用数据
            $row['apiCallTotal'] = Stat::queryTag($row['idstr'] . '_' . Stat::StatName);
            $row['apiCallToday'] = Stat::queryDayTag($row['idstr'] . '_' . Stat::StatName);

            // Apikey获取
            $apikeyData = self::$db->fetch(PageDocApikeyModel, [self::$data['VERIFY']['id'], $row['idstr']]);
            $row['apikey'] = $apikeyData['apikey'];

            self::setViewCustomData($row);
            self::loadView('doc.php');
        } else {
            // 载入404错误视图
            self::error404();
        }
    }


    /* 接口映射入口 */
    public function api()
    {
        // 调用限制
        $opgroup = self::$data['VERIFY']['opgroup'];
        $opgroup == 4 || self::callLimit();
        // 如若非管理员则开启调用次数限制

        $row = self::$db->fetch(PageDocModel, [self::$val]);

        // 判断接口本体文件是否存在
        $isExists = file_exists(HULICORE_DATA_PATH . '/api/' . self::$val . '.php');
        $verifyKey = loadConfig('website.php')['api'][self::$val];
        if (!empty($verifyKey) || $isExists) {
            $state = $row['state'];

            // 条件:状态为0(接口维护) 且 不是管理员 (管理员可绕过维护状态进行接口测试)
            $state == 0 && self::$data['VERIFY']['opgroup'] != 4  && self::printResult(510, ['message' => self::$data['WEB_SAFE']['badapimsg']]);

            // 计入接口调用统计数据
            Stat::WriteTag($row['idstr'] . '_' . Stat::StatName);

            // apikey相关操作
            $apikey = $_REQUEST['apikey'];
            $verifyApikey = self::verifyApikey($row['idstr'], $apikey);
            if ($verifyApikey) {
                Stat::WriteTag('user_' . $verifyApikey['account'] . ':total', 1, false);
                Stat::WriteTag('user_' . $verifyApikey['account'] . ':' . $row['idstr'] . '_' . Stat::StatName, 1, false);
            } else if (($row['coin'] > 0 && !$verifyApikey && $opgroup != 4) || ($row['coin'] <= 0 && !empty($apikey))) {
                self::printResult(611);
            }

            if ($isExists) {
                // 加载接口本体文件
                include_once(HULICORE_DATA_PATH . '/api/' . self::$val . '.php');
            } else if (loadConfig('theme.php')['type'] != 'HotaruCore') {
                switch ($row['returnType']) {
                    case 'image':
                        header('Content-type: image/png');
                        break;
                    default:
                        header('Content-type: ' . ($row['returnType'] ? $row['returnType'] : 'application/json'));
                }
                $params = '';
                foreach ($_REQUEST as $key => $value) {
                    $params += "&$key=$value";
                }
                echo file_get_contents(self::$URL . "/site/api/" . self::$val . "?verify=$verifyKey" . $params);
            } else {
                self::error404();
            }

            // 对于返回为text/html格式的接口进行输出前端控制台信息
            $row['returnType'] !== 0 || statement();
        } else {
            self::error404();
        }
    }


    /* 文章入口 */
    public function article()
    {
        $config = loadConfig('article.php');
        $viewFile = $config[self::$val];
        $viewFilePath = HULICORE_BASE_VIEW_PATH . '/article/';
        isset($viewFile) || self::error404();
        file_exists($viewFilePath . $viewFile) || self::error404();
        self::setViewCustomData($viewFilePath . $viewFile);
        self::loadView('article.php');
    }


    /* 静态资源映射入口 */
    public function assets()
    {
        // 根据当前主题定位到所需的静态资源根目录
        $path = self::$data['THEME_PATH'] . '/assets/' . self::$val;
        // 判断静态资源文件是否真实存在
        if (file_exists($path)) {
            // 获取输入的静态资源文件后缀名
            // 引入相应配置文件判断该后缀名文件的对应http返回格式(content type)
            $fileType = substr($path, strrpos($path, '.') + 1);
            $fileFormatList = loadConfig('assets.php');

            // 找不到格式直接写成二进制数据文件格式
            $contentType = $fileFormatList[$fileType] ?? 'application/octet-stream';
            // 设置请求头并引入文件
            header('Content-type: ' . $contentType);
            require($path);
        } else {
            self::error404();
        }
    }



    /* testing */
    public function user()
    {
        $path = self::$data['THEME_PATH'] . '/user/' . self::$val . '.html';
        if (file_exists($path)) {
            self::loadView('user/' . self::$val . '.html');
        } else {
            self::error404();
        }
    }

    public function init()
    {
        /* 
        $rows = self::$db->fetchAll(PageIndexModel);
        foreach($rows as $val) {

        } */
        self::$db->exec("CREATE TABLE huliapi_lib_stat (
            id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            sign varchar(255) default NULL,
            result INT(11) default NULL,
            type_ varchar(255) default NULL
        )");
        $rows = self::$db->fetchAll("SELECT * FROM huliapi_api");
        foreach ($rows as $val) {
            $idstr = $val['idstr'];
            $sign = "{$idstr}_inside";
            $total = intval(stat::QueryTag($sign));
            self::$db->exec("INSERT INTO huliapi_lib_stat(result, type_, sign) VALUES(?, ?, ?)", [$total, "total", $sign]);
            $day = intval(stat::QueryDayTag($sign));
            self::$db->exec("INSERT INTO huliapi_lib_stat(result, type_, sign) VALUES(?, ?, ?)", [$day, date('Y_m_d'), $sign]);
            echo 'OK=>> ' . $idstr . ' <==<br>';
        }

        // echo self::$db->

        /*   $data = self::$db->fetchAll("SELECT * FROM huliapi_api");
        $list = [
            'text/html', 'text/plain', 'application/json', 'image', null, 'location', 'video', 'audio'
        ]; */
        /* 
        $list2 = [
            'text/html' => 'GET',
            'text/plain' => 'POST',
            'application/json' => 'GET/POST'
        ]; */

        /*         $list2 = [
            'GET',
            'POST',
            'GET/POST'
        ];
        foreach ($data as $val) {
            $sql = "UPDATE huliapi_api SET returnTemp = ? WHERE id = ? AND returnType = 'application/json'";
            echo self::$db->exec($sql, [stripslashes(urldecode(json_encode(json_decode($val['returnTemp']), JSON_PRETTY_PRINT | 256))), $val['id']]);
            $sql = "UPDATE huliapi_api SET returnType = ? WHERE id = ?";
            // echo self::$db->exec($sql, [$list[intval($val['returnType'])], $val['id']]);
            $sql = "UPDATE huliapi_api SET requestType = ? WHERE id = ?";
            // echo self::$db->exec($sql, [$list2[($val['requestType'])], $val['id']]);
        } */
    }
}
