<?php


namespace Base\Controllers\Other;

use Base\Controllers\Controller;
use function Core\Func\location;

class IndexController extends Controller
{
    public function index()
    {
        self::$data['VERIFY'] || location(APP_ADMIN_PATH . '/login');
        self::loadView('admin/other.php');
    }
}