<?php
/*
 * @Author: Biyuehu biyuehuya@gmail.com
 * @Blog: http://imlolicon.tk
 * @Date: 2023-01-17 13:36:45
 */

class Route
{
    // 地址参数
    public static $rulePar;
    // 是否开启防XSS攻击
    public static $antixss;
    public static $controllerPath = HULICORE_BASE_CONTROLLER_PATH;


    /**
     * Any(任意请求)方法
     * @param string $rule 地址规则
     * @param string|callback $method 方法
     * @param string $antixss 是否开启防XSS攻击,默认true
     */
    public static function any($rule, $method, $antixss = true)
    {
        switch ($_SERVER['REQUEST_METHOD']) {
            case 'GET':
                self::get($rule, $method, $antixss);
                break;
            case 'POST':
                self::post($rule, $method, $antixss);
                break;
            default:
                self::other($rule, $method, $antixss);
        }
    }


    /**
     * Get请求方法
     * @param string $rule 地址规则
     * @param string|callback $method 方法
     * @param string $antixss 是否开启防XSS攻击,默认true
     */
    public static function get($rule, $method, $antixss = true)
    {
        self::requrestCheck();
        self::$antixss = $antixss;
        // 期望请求方式是否与实际请求方式一致
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $requestUrl = self::requestUrl();
            // 地址与请求链接是否匹配
            if (self::getMatch($rule, $requestUrl)) {
                // 运行方法
                self::runMethod($method);
                exit();
            } else {
                // echo '404';
                // exit();
            }
        }
        return;
    }


    /** 
     * Post请求方法
     * @param string $rule 地址规则
     * @param string|callback $method 方法
     * @param string $antixss 是否开启防XSS攻击,默认true
     */
    public static function post($rule, $method, $antixss = true)
    {
        self::requrestCheck();
        self::$antixss = $antixss;
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $requestUrl = self::requestUrl();
            if (self::getMatch($rule, $requestUrl)) {
                self::runMethod($method);
                exit();
            } else if ($rule == $requestUrl) {
                self::runMethod($method);
                exit();
            } else {
                // echo '404';
                // exit();
            }
        }
        return;
    }


    
    /** 
     * 其它请求方法
     * @param string $rule 地址规则
     * @param string|callback $method 方法
     * @param string $antixss 是否开启防XSS攻击,默认true
     */
    public static function other($rule, $method, $antixss = true)
    {
        self::requrestCheck();
        self::$antixss = $antixss;
        if ($_SERVER['REQUEST_METHOD'] != 'GET' && $_SERVER['REQUEST_METHOD'] != 'POST') {
            $requestUrl = self::requestUrl();
            if (self::getMatch($rule, $requestUrl)) {
                self::runMethod($method);
                exit();
            } else if ($rule == $requestUrl) {
                self::runMethod($method);
                exit();
            } else {
                // echo '404';
                // exit();
            }
        }
        return;
    }


    /**
     * HTTP状态错误处理
     * @param int $code 状态码
     * @param string|callback $method 方法
     */
    public static function error($code, $method = null)
    {
        http_response_code($code);
        $array = array(
            403 => $method ?? function () {
                exit('Forbidden');
            },
            404 => $method,
        );
        empty($array[$code]) || self::runMethod($array[$code]);
    }


    /**
     * 请求检查 检查请求是否在允许列表里
     */
    private static function requrestCheck()
    {
        $allowd = false;
        $allowdArr = loadConfig('method.php');
        foreach($allowdArr as $val ) {
            $val != $_SERVER['REQUEST_METHOD'] || $allowd = true;
        }
        if ($allowd !== true) {
            printDebug("Core Route Error:Not allowed method:{$_SERVER['REQUEST_METHOD']}");
            exit();
        }
    }


    /**
     * 获取实际请求URL
     * @return string $url
     */
    private static function requestUrl()
    {
        $url = $_SERVER['REQUEST_URI'];
        // 分离URL请求参数
        $url = explode('?', $url)[0];

        if (substr($url, 0, 10) == '/index.php') {
            // 如果开头是/index.php则截取掉
            $url = substr($url, 10);
        }

/*         if (substr($url, -1) == '/' && $url != '/') {
            $url = substr($url, 0, -1);
        } */

        // 意外处理
        !empty($url) || $url = '/';

        return $url;
    }


    /**
     * 地址匹配
     * @param string $rule 地址规则(期望)
     * @param string $url URL(实际)
     */
    private static function getMatch($rule, $url)
    {
        // 对于带地址参数{val}的地址(rule)先使用正则匹配
        // 判断地址参数规则是否匹配
        preg_match_all('/\{(.*)\}/', $rule, $dataArray);
        $isok = false;

        if (count($dataArray[0]) > 0) {
            // 预存一下变量并开始遍历
            $match = $rule;
            foreach ($dataArray as $val) {
                $match = str_replace($val, '(.*)', $match);
            }
            // 拼接出新的
            $match = '/' . str_replace('/', '\/', $match) . '/';
            if (preg_match($match, $url, $dataArray2) && substr($url, 0, strpos($rule, '{')) == substr($rule, 0, strpos($rule, '{'))) {
                self::$rulePar = $dataArray2[1];
                $isok = true;
            }
        }

        // 地址参数规则不匹配则进行默认匹配
        if ($isok !== true) {
            // 此处的$url经过处理,补全一下?后面的参数
            $pars = explode('?', $_SERVER['REQUEST_URI'])[1];
            $pars = $pars ? '?' . $pars : '';
            // 如果地址规则末尾待/,实际URL带个/与地址规则匹配的话(说明请求时没有带/),则转向至带/链接下
            (substr($rule, -1) == '/' && $url . '/' == $rule) && (location($rule . $pars) && exit());

            $rule != $url || $isok = true;
        }
        return $isok;
    }


    /**
     * 运行方法
     * @param string|callback $method 方法
     */
    private static function runMethod($method)
    {
        // 判断是控制器方法还是回调函数方法
        if (gettype($method) == 'string') {
            // 传入控制器并加载
            self::loadController($method);
        } else {
            // 传入地址参数并运行回调函数
            $method(self::$rulePar);
        }
    }


    /**
     * 加载控制器
     * @param string $method 控制器
     */
    private static function loadController($method)
    {
        // 分离出控制器路径与控制器名
        $dataArray = explode('@', $method);
        $controllerName = $dataArray[0];
        $actionName = $dataArray[1];
        $controllerDir = '';

        // 判断控制器路径是否为多层目录
        $last = strrpos($controllerName, '/');
        if ($last) {
            $controllerDir = substr($controllerName, 0, $last) . '/';
            $controllerName = substr($controllerName, $last + 1);
        }

        // 拼接出控制器真实路径并判断控制器是否存在
        $path = self::$controllerPath . '/' . $controllerDir . $controllerName . '.php';
        if (file_exists($path)) {
            // 引入控制器文件并逐一判断Class与方法是否存在
            require($path);
            if (class_exists($controllerName)) {
                if (method_exists($controllerName, $actionName)) {
                    // 实例化并执行
                    (new $controllerName())->$actionName();
                } else {
                    printDebug('Core Route Error:Method does not exist ' . $actionName);
                }
            } else {
                printDebug('Core Route Error:Class does not exist ' . $controllerName);
            }
        } else {
            printDebug('Core Route Error:File does not exist ' . $path);
        }
        exit();
    }
}
