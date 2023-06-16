<?php

class IndexController extends Controller
{
    public function index()
    {
        self::$data['VERIFY'] || location(APP_ADMIN_PATH . '/login');
        self::loadView('admin/other.php');
    }
}