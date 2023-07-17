<?php
/*
 * @Author: Biyuehu biyuehuya@gmail.com
 * @Blog: http://imlolicon.tk
 * @Date: 2023-07-17 11:05:45
 */


namespace Base\Controllers\Site;

use Base\Controllers\Controller;
use Lib\Stat;

use function Core\Func\getUserIp;
use function Core\Func\loadConfig;

class IndexController extends Controller
{
    public $CONFIG;

    public function init()
    {
        $this->CONFIG = loadConfig('theme.php');
        if ($this->CONFIG['type'] != 'HotaruCore') {
            self::printResult(614);
        }
    }

    /* 站点接口映射入口 */
    public function api()
    {
        $this->init();
        // 调用限制
        self::callLimit();

        $row = self::$db->fetch(PageDocModel, [self::$val]);

        // 判断接口本体文件是否存在
        if (file_exists(HULICORE_DATA_PATH . '/api/' . self::$val . '.php')) {
            $state = $row['state'];

            // 条件:状态为0(接口维护) 且 当前未登录(管理员可绕过维护状态进行接口测试)
            $state == 0 && !self::verifyLogin() && self::printResult(510, ['message' => self::$data['WEB_SAFE']['badapimsg']]);

            // 计入接口调用统计数据
            Stat::WriteTag($row['idstr'] . '_' . Stat::StatName);

            // apikey相关操作
            $apikey = $_REQUEST['verify'];
            $verifyApikey = self::verifyApikey($row['idstr'], $apikey);
            if ($verifyApikey) {
                Stat::WriteTag('user_' . $verifyApikey['account'] . ':total', 1, false);
                Stat::WriteTag('user_' . $verifyApikey['account'] . ':' . $row['idstr'] . '_' . Stat::StatName, 1, false);
            } else {
                self::printResult(611);
            }

            $verifyApikey['website'] && gethostbyname($verifyApikey['website']) == getUserIp() || self::printResult(613);

            // 加载接口本体文件
            include_once(HULICORE_DATA_PATH . '/api/' . self::$val . '.php');
        } else {
            self::error404();
        }
    }

    public function info()
    {
        $this->init();
        $_REQUEST['website'] && gethostbyname($_REQUEST['website']) == getUserIp() && self::$db->fetch(PageSiteInfoModel, [$_REQUEST['website']])  || self::printResult(613);
        self::printResult(500, [
            'notice' => self::$data['WEB_INFO']['site_notice']
        ]);
    }

    public function update()
    {
        $this->init();
        $version = $_REQUEST['version'];
        if ($version != HULICORE_INFO_VERSION) {
            self::printResult(502, [
                'version' => HULICORE_INFO_VERSION,
                'repo' => $this->CONFIG['repo'],
                'descr' => self::$data['WEB_INFO']['site_update']
            ]);
        } else {
            self::printResult(500);
        }
    }
}
