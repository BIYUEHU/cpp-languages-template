<?php


namespace Base\Controllers\Other;

use Base\Controllers\Controller;

use function Core\Func\loadConfig;
use function Core\Func\location;

class IndexController extends Controller
{
    public function init()
    {
        if (loadConfig('theme.php')['type'] != 'HotaruCore') {
            self::printResult(614);
        }
    }

    public function index()
    {
        $this->init();
        self::$data['VERIFY'] || location(APP_ADMIN_PATH . '/login');
        self::loadView('admin/other.php');
    }
}