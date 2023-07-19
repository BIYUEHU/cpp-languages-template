<?php


namespace Base\Controllers\Other;

use Base\Controllers\Controller;
use function Core\Func\location;

class IndexController extends Controller
{
    public function init()
    {
        if (!file_exists(HULICORE_BASE_CONTROLLER_PATH . '/Site/IndexController.php')) {
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