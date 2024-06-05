<?php
/*
 * @Author: Hotaru biyuehuya@gmail.com
 * @Blog: http://hotaru.icu
 * @Date: 2023-01-17 13:36:45
 */

namespace Core;

use function Core\Func\printDebug;
use function Core\Func\loadConfig;

class Common
{
    // 数据库实体(明明原本那↑么↓大的~现在却小小的一个 真卡哇伊的说~)
    private static $db;
    // FETCH模式
    private static $fetch_mode;


    public function __construct()
    {
        // 数据库实体为空时连接数据库
        self::$db || self::connect();
    }


    /* 防止克隆 */
    private function __clone()
    {
    }


    /* 连接数据库 */
    // 全局仅进行连接数据库一次
    private static function connect($drivers = [])
    {
        // 加载数据库配置文件并进行简单处理
        $config = loadConfig('database.php');
        $type = $config['type'] ?? 'mysql';
        $host = $config['host'] ?? 'localhost';
        $port = $config['port'] ?? 3306;
        $dbName = $config['dbName'] ?? 'my_database';
        $charset = $config['charset'] ?? 'utf8';
        $dsn = "{$type}:host={$host};port={$port};dbname={$dbName};charset={$charset}";
        $userName = $config['userName'] ?? 'root';
        $passWord = $config['passWord'] ?? 'root';
        self::$fetch_mode = $config['fetchMode'] ?? \PDO::FETCH_ASSOC;

        $drivers[\PDO::ATTR_ERRMODE] = $drivers[\PDO::ATTR_ERRMODE] ?? \PDO::ERRMODE_EXCEPTION;

        // 错误侦测
        try {
            self::$db = @new \PDO($dsn, $userName, $passWord, $drivers);
        } catch (\PDOException $error) {
            self::exception($error);
        }
    }


    /**
     * 错误抛出
     * @param \PDOException
     */
    private static function exception(\PDOException $error)
    {
        printDebug('Core Common Error <br/>');
        printDebug('File: ' . $error->getFile() . '<br/>');
        printDebug('Lile: ' . $error->getLine() . '<br/>');
        printDebug('Descr: ' . $error->getMessage() . '<br/>');
    }


    /**
     * 查询操作
     * @param string $sql SQL语句
     * @param array $data 传入到SQL的数据(依次排列)
     */
    private static function query($sql, $data = [])
    {
        try {
            $stmt = self::$db->prepare($sql);
            $stmt->execute($data);

            $stmt->setFetchMode(self::$fetch_mode);

            return $stmt;
        } catch (\PDOException $error) {
            self::exception($error);
        }
    }


    /**
     * 公共:执行操作
     * @param string $sql SQL语句
     * @param array $data 传入到SQL的数据(依次排列)
     */
    public static function exec($sql, $data = [])
    {
        return self::query($sql, $data)->rowCount();
    }


    /**
     * 公共:设置自增长ID
     */
    public static function insertId()
    {
        return self::$db->lastInsertId();
    }


    /**
     * 公共:查询一行
     * @param string $sql SQL语句
     * @param array $data 传入到SQL的数据(依次排列)
     */
    public static function fetch($sql, $data = [])
    {
        return self::query($sql, $data)->fetch();
    }


    /**
     * 公共:查询全部
     * @param string $sql SQL语句
     * @param array $data 传入到SQL的数据(依次排列)
     */
    public static function fetchAll($sql, $data = [])
    {
        return self::query($sql, $data)->fetchAll();
    }
}
