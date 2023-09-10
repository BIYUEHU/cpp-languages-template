<?php
/*
 * @Author: Hotaru biyuehuya@gmail.com
 * @Blog: http://hotaru.icu
 * @Date: 2022-12-19 22:59:51
 */

namespace HuliMain;

final class Hulicore
{
    public function run()
    {
        /* 设置常量 */
        $this->_set_const();
        /* 导入文件 */
        $this->_import_file();
        /* 用户配置 */
        $this->_use_config();
        /* 设置用户常量 */
        $this->_set_const_usr();
        /* 初始化 */
        $this->_init();
    }


    private function _set_const()
    {
        $path = str_replace('\\', '/', __FILE__);
        define('HULICORE_ROOT_PATH', dirname($path));

        /* Core */
        define('HULICORE_APP_PATH', HULICORE_ROOT_PATH . '/app');
        define('HULICORE_CORE_PATH', HULICORE_APP_PATH . '/core');
        define('HULICORE_LIB_PATH', HULICORE_APP_PATH . '/lib');
        define('HULICORE_BASE_PATH', HULICORE_APP_PATH . '/base');

        /* App */
        define('HULICORE_BASE_CONTROLLER_PATH', HULICORE_BASE_PATH . '/Controllers');
        define('HULICORE_BASE_MODEL_PATH', HULICORE_BASE_PATH . '/Models');
        define('HULICORE_BASE_VIEW_PATH', HULICORE_BASE_PATH . '/Views');

        /* Root */
        define('HULICORE_CONFIG_PATH', HULICORE_ROOT_PATH . '/config');
        define('HULICORE_DATA_PATH', HULICORE_ROOT_PATH . '/data');
        define('HULICORE_PUBLIC_PATH', HULICORE_ROOT_PATH . '/public');
        define('HULICORE_USR_PATH', HULICORE_ROOT_PATH . '/usr');
    }


    private function _import_file()
    {
        /* Core */
        /* 路由核心 */
        require(HULICORE_CORE_PATH . '/route.php');
        /* 数据库核心 */
        require(HULICORE_CORE_PATH . '/common.php');
        /* 核心公共函数 */
        require(HULICORE_CORE_PATH . '/func/function.php');

        /* 全局Lib */
        /* 统计扩展 */
        require(HULICORE_LIB_PATH . '/stat.class.php');

        /* App */
        /* 主控制器 */
        require(HULICORE_BASE_CONTROLLER_PATH . '/Controller.php');
        /* 控制器核心函数 */
        require(HULICORE_BASE_CONTROLLER_PATH . '/Method.php');
        /* 模型 */
        require(HULICORE_BASE_MODEL_PATH . '/Models.php');
        /* 应用常量 */
        require(HULICORE_APP_PATH . '/const.ini.php');
    }


    private function _use_config()
    {
        $config = \Core\Func\loadConfig('config.php');
        /* Debug */
        define('HULICORE_SET_DEBUG', $config['debug'] === true ? 'ON' : 'OFF');
        define('HULICORE_SET_DEBUG_MODE', $config['debug_mode']);
    }


    private function _set_const_usr()
    {
        /* Version */
        define('HULICORE_INFO_VERSION', '3.1.2');
        /* Type */
        define('HULICORE_INFO_TYPE', file_exists(HULICORE_BASE_CONTROLLER_PATH . '/Site/IndexController.php'));
    }


    private function _init()
    {
        HULICORE_SET_DEBUG == 'ON' || error_reporting(0);
        ini_set('session.cookie_httponly', 1); // 设置防止xss攻击
        session_start(); // 开启session
        date_default_timezone_set('Asia/Shanghai'); // 设置时区

        require(HULICORE_APP_PATH . '/app.php');
    }
}
