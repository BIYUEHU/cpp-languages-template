<?php

namespace Base\Controllers\Admin;

use Base\Controllers\Controller;
use function Core\Func\location;
use function Base\Controllers\getAllThemes;
use function Core\Func\loadConfig;

class IndexController extends Controller
{
    public function index()
    {
        self::$data['VERIFY']['opgroup'] == 4 || location(APP_USER_PATH . '/login');
        
        if (loadConfig('theme.php')['type'] != 'HotaruCsore') {
            $data = file_get_contents(self::$URL . 'site/info?website=' . $_SERVER['HTTP_HOST']);
            json_decode($data)->code == 500 || location('/help.html');
        }
        self::loadView('admin/index.php');
    }


    /* 登录 */


    /* 网站设置 */
    public function webset()
    {
        self::$data['VERIFY']['opgroup'] == 4 || location(APP_USER_PATH . '/login');
        self::setViewCustomData(getAllThemes());
        self::loadView('admin/webset.php');
    }


    /* 接口三套 */
    public function apiadd()
    {
        self::$data['VERIFY']['opgroup'] == 4 || location(APP_USER_PATH . '/login');
        self::loadView('admin/apiadd.php');
    }

    public function apilist()
    {
        self::$data['VERIFY']['opgroup'] == 4 || location(APP_USER_PATH . '/login');
        self::loadView('admin/apilist.php');
    }

    public function apiedit()
    {
        self::$data['VERIFY']['opgroup'] == 4 || location(APP_USER_PATH . '/login');
        $data = self::$db->fetch(PageAdminApieditModel, [$_GET['idstr']]);
        self::setViewCustomData($data);
        self::loadView('admin/apiedit.php');
    }


    /* 账户三套 */
    public function account()
    {        
        self::$data['VERIFY']['opgroup'] == 4 || location(APP_USER_PATH . '/login');
        self::loadView('admin/account.php');
    }

    public function accountadd()
    {
        self::$data['VERIFY']['opgroup'] == 4 || location(APP_USER_PATH . '/login');
        self::loadView('admin/accountadd.php');
    }

    public function accountedit()
    {
        self::$data['VERIFY']['opgroup'] == 4 || location(APP_USER_PATH . '/login');
        $data = self::$db->fetch(PageAdminAccounteditModel, [$_GET['id']]);
        self::setViewCustomData($data);
        self::loadView('admin/accountedit.php');
    }


    /* 网站安全 */
    public function websafe()
    {
        self::$data['VERIFY']['opgroup'] == 4 || location(APP_USER_PATH . '/login');
        self::loadView('admin/websafe.php');
    }


    /* 主题设置 */
    public function themes()
    {
        self::$data['VERIFY']['opgroup'] == 4 || location(APP_USER_PATH . '/login');
        self::loadView('admin/themes.php');
    }


    /* 插件设置 */
    public function plugins()
    {
        self::$data['VERIFY']['opgroup'] == 4 || location(APP_USER_PATH . '/login');
        self::setViewCustomData(['email' => self::getSetData('plugins_email')]);
        self::loadView('admin/plugins.php');
    }


    /* 文件上传 */
    public function fileupload()
    {
        self::$data['VERIFY']['opgroup'] == 4 || location(APP_USER_PATH . '/login');
        self::loadView('admin/fileupload.php');
    }
}
