<?php

class IndexController extends Controller
{
    public function index()
    {
        self::$data['VERIFY'] || location(APP_USER_PATH . '/login');
        $data = [
            'numApi' => count(self::$db->fetchAll(PageUserIndexModel, [self::$data['VERIFY']['id']])),
            'call' => Stat::QueryTag('user_' . self::$data['VERIFY']['id'] . ':total') 
        ];
        self::setViewCustomData($data);
        self::loadView('user/index.php');
    }


    /* 登录 */
    public function login()
    {
        !self::$data['VERIFY'] || location(APP_USER_PATH . '/');
        $tempSet = 'de';
        if (isset($_GET['sp']) || (!isset($_GET['sp']) && $tempSet == 'sp')) {
            self::loadView('user/loginsp.php');

        } else if (isset($_GET['de']) || (!isset($_GET['de']) && $tempSet == 'de')){
            self::loadView('user/login.php');
        }
    }


    public function loginout()
    {
        self::$data['VERIFY'] || self::printResult(509);
        unset($_SESSION['hulicore_loginaccount']);
        location(APP_USER_PATH . '/login');
    }


    public function apilist()
    {        
        self::$data['VERIFY']['opgroup'] >= 3 || location(APP_USER_PATH . '/login');
        self::loadView('user/apilist.php');
    }


    public function apishop()
    {        
        self::$data['VERIFY']['opgroup'] >= 3 || location(APP_USER_PATH . '/login');
        self::loadView('user/apishop.php');
    }


    public function coinpay()
    {        
        self::$data['VERIFY']['opgroup'] >= 3 || location(APP_USER_PATH . '/login');
        self::loadView('user/coinpay.php');
    }


    /* 个人资料 */
    public function person()
    {
        self::$data['VERIFY']['opgroup'] >= 3 || location(APP_USER_PATH . '/login');
        self::loadView('user/person.php');
    }
}
