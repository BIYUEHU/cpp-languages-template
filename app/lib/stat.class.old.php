<?php

namespace Lib;

use function Core\Func\deleteDir;

class Stat {
    private static $filePath;
    private static $fileDayPath;
    private static $result = null;
    private const ErrorCodes = array(
        500 => 'success',
        501 => 'fail:target already exists',
        502 => 'fail:target does not exist',
        503 => 'fail:parameter error',
        504 => 'fail:unknown error'
    );
    public const StatName = 'inside';
    public static $errorCode;

    private static function _InitPath($tag) {
        self::$filePath = HULICORE_DATA_PATH . '/stats/' . $tag . '/' . 'total.dat';
        self::$fileDayPath = HULICORE_DATA_PATH . '/stats/' . $tag . '/' . date('Y_m_d') . '.dat';
    }


    public static function AddTag($tag) {
        self::_InitPath($tag);
        if (file_exists(self::$filePath)) {
            self::$errorCode = 501;
            return false;
        } else {
            mkdir(HULICORE_DATA_PATH . '/stats/' . $tag . '/');
            file_put_contents(self::$filePath, '0');
            self::$errorCode = 500;
            return true;
        }
    }


    public static function DelTag($tag) {
        self::_InitPath($tag);
        if (!file_exists(self::$filePath)) {
            self::$errorCode = 502;
            return false;
        } else {
            deleteDir(HULICORE_DATA_PATH . '/stats/' . $tag);
            self::$errorCode = 500;
            return true;
        }

    }


    public static function WriteTag($tag, $step = 1, $isadd = true) {
        self::_InitPath($tag);
        if (!file_exists(self::$filePath)) {
            self::$errorCode = 502;
            return false;
        } else {
            $val = intval(file_get_contents(self::$filePath));
            file_put_contents(self::$filePath, $val + $step);
            $valDay = file_exists(self::$fileDayPath) != true ? 0 : intval(file_get_contents(self::$fileDayPath));
            file_put_contents(self::$fileDayPath, $valDay + $step);            
            
            if ($isadd && $tag != 'api_call_' . self::StatName && $tag != 'stat_' . self::StatName) {
                self::WriteTag('api_call_' . self::StatName, 1, false);
            }
            self::$errorCode = 500;
            return true;
        }
    }


    public static function QueryTag($tag) {
        $tag = $tag == 'stat_' . self::StatName ? 'api_call_' . self::StatName : $tag;
        self::_InitPath($tag);
        if (!file_exists(self::$filePath)) {
            self::$errorCode = 502;
            return false;
        } else {
            self::$errorCode = 500;
            self::$result = file_get_contents(self::$filePath);
            return self::$result;
        }
    }


    public static function QueryDayTag($tag, $step = 0) {
        $tag = $tag == 'stat_' . self::StatName ? 'api_call_' . self::StatName : $tag;
        self::_InitPath($tag);
        if (!file_exists(self::$filePath)) {
            self::$errorCode = 502;
            return false;
        } else if ($step < 0) {
            self::$errorCode = 503;
            return false;
        }

        $fileDayPath = $step = 0 ? self::$fileDayPath : HULICORE_DATA_PATH . '/stats/' . $tag . '/' . date('Y_m_d', strtotime(-$step . 'day')) . '.dat';
        if (!file_exists($fileDayPath)) {
            self::$result = 0;
        } else {
            self::$result = file_get_contents($fileDayPath);
        }
        self::$errorCode = 500;
        return self::$result;
    }


    protected static function BackTag($tag) {
        self::_InitPath($tag);

    }


    public function Result() {
        return array(
            'code' => self::$errorCode,
            'message' => self::ErrorCodes[self::$errorCode],
            'data' => self::$result
        );
    }
}
