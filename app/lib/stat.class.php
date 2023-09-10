<?php
/*
 * @Author: Biyuehu biyuehuya@gmail.com
 * @Blog: http://hotaru.icu
 * @Date: 2023-06-16 14:20:19
 */

namespace Lib;

use Core\Common;
use function Core\Func\loadConfig;

class Stat {
    private static $result = null;
    private static $db;
    private static $prefix;
    private const ErrorCodes = array(
        500 => 'success',
        501 => 'fail:target already exists',
        502 => 'fail:target does not exist',
        503 => 'fail:parameter error',
        504 => 'fail:unknown error'
    );
    public const StatName = 'inside';
    public static $errorCode;


    private static function dbGetData($tag, $type = 'total')
    {
        self::$db = new Common();
        self::$prefix = loadConfig('database.php')['prefix'];
        return self::$db->fetch("SELECT * FROM " . self::$prefix . "lib_stat WHERE sign = ? AND type_ = ?", [$tag, $type]);
    }

    private static function dbAddData($tag, $type = 'total', $step = 0)
    {
        return self::$db->exec("INSERT INTO " . self::$prefix . "lib_stat(sign, result, type_) VALUES(?, ?, ?)", [$tag, $step, $type]);
    }

    private static function dbUpdateData($tag, $type = 'total', $step = 0)
    {
        return self::$db->exec("UPDATE " . self::$prefix . "lib_stat SET result = ? WHERE sign = ? AND type_ = ?", [$step, $tag, $type]);
    }

    private static function dbDelData($tag) {
        return self::$db->exec("DELETE FROM " . self::$prefix . "lib_stat WHERE sign = ?", [$tag]);
    }

    private static function existsTag($data) {
        if (empty($data['sign'])) {
            self::$errorCode = 502;
            return false;
        } else {
            return true;
        }
    }


    public static function AddTag($tag) {
        $data = self::dbGetData($tag);
        if (!self::existsTag($data)) {
            self::dbAddData($tag);
            self::$errorCode = 500;
            return true;
        }
        self::$errorCode = self::$errorCode ?? 501;
        return false;
    }


    public static function DelTag($tag) {
        $data = self::dbGetData($tag);
        if (self::existsTag($data)) {
            self::dbDelData($tag);
            self::$errorCode = 500;
            return true;
        }
        return false;
    }


    public static function WriteTag($tag, $step = 1, $isadd = true) {
        $data = self::dbGetData($tag);
        if (self::existsTag($data)) {
            $val = intval($data['result']);
            self::dbUpdateData($tag, 'total', $val + $step);
            $dataDay = self::dbGetData($tag, date('Y_m_d'));
            if (empty($dataDay['sign'])) {
                self::dbAddData($tag, date('Y_m_d'), $step);
            } else {
                self::dbUpdateData($tag, date('Y_m_d'), $dataDay['result'] + $step);
            }

            if ($isadd && $tag != 'api_call_' . self::StatName && $tag != 'stat_' . self::StatName) {
                self::WriteTag('api_call_' . self::StatName, 1, false);
            }
            self::$errorCode = 500;
            return true;
        }
        return false;
    }


    public static function QueryTag($tag) {
        // 判断tag是否为stat接口自己 是则作为api_call_处理
        $tag = $tag == 'stat_' . self::StatName ? 'api_call_' . self::StatName : $tag;
        $data = self::dbGetData($tag);
        if (self::existsTag($data)) {
            self::$errorCode = 500;
            self::$result = intval($data['result']);
            return self::$result;
        }
        return false;
    }


    public static function QueryDayTag($tag, $step = 0) {
        $tag = $tag == 'stat_' . self::StatName ? 'api_call_' . self::StatName : $tag;
        $data = self::dbGetData($tag);
        if (self::existsTag($data)) {
            self::$errorCode = 500;
            $date = ($step == 0 ? date('Y_m_d') : date('Y_m_d', strtotime(-$step . 'day')));
            $dataDay = self::dbGetData($tag, $date);
            self::$result = intval($dataDay['result']) ?? 0;
            return self::$result;
        } else if ($step < 0) {
            self::$errorCode = 503;
        }
        return false;
    }


    protected static function BackTag() {
        // ?
    }


    public function Result() {
        return array(
            'code' => self::$errorCode,
            'message' => self::ErrorCodes[self::$errorCode],
            'data' => self::$result
        );
    }
}
