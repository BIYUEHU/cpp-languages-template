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
        if (!file_exists(HULICORE_BASE_CONTROLLER_PATH . '/Site/IndexController.php')) {
            self::printResult(614);
        }
    }

    /* 站点接口映射入口 */
    public function api()
    {
        $this->init();
        self::callLimit();

        $row = self::$db->fetch(PageDocModel, [self::$val]);

        if (file_exists(HULICORE_DATA_PATH . '/api/' . self::$val . '.php')) {
            $state = $row['state'];

            $state == 0 && self::printResult(510, ['message' => self::$data['WEB_SAFE']['badapimsg']]);

            Stat::WriteTag($row['idstr'] . '_' . Stat::StatName);

            $apikey = $_REQUEST['verify'];
            $verifyApikey = self::verifyApikey($row['idstr'], $apikey);
            if ($verifyApikey) {
                Stat::WriteTag('user_' . $verifyApikey['account'] . ':total', 1, false);
                Stat::WriteTag('user_' . $verifyApikey['account'] . ':' . $row['idstr'] . '_' . Stat::StatName, 1, false);
            } else {
                self::printResult(611);
            }
            
            $da = self::$db->fetch(PageAdminAccounteditModel, [$verifyApikey['account']]);
            $da['website'] && gethostbyname($da['website']) == getUserIp() || self::printResult(613);

            // 加载接口本体文件
            include_once(HULICORE_DATA_PATH . '/api/' . self::$val . '.php');
        } else {
            self::error404();
        }
    }

    public function info()
    {
        $this->init();
        $_REQUEST['website'] && self::$db->fetch(PageSiteInfoModel, [$_REQUEST['website']])  || self::printResult(613);
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
