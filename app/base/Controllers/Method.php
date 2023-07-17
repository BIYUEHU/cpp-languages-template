<?php
/*
 * @Author: Biyuehu biyuehuya@gmail.com
 * @Blog: http://imlolicon.tk
 * @Date: 2023-01-17 13:36:45
 */

namespace Base\Controllers;

use function Core\Func\matchSearch;
use function Core\Func\consolelog;
use function Core\Func\getAllDirs;

/**
 * 处理返回类型(doc页面)
 * @param string $val 原返回类型
 * @param string $val2 原返回示例
 * @return string 返回HTML实体
 */
function handleReturnType($val, $val2)
{
    if (matchSearch($val, '/application\/json/')) {
        return '<code class="json">' . stripslashes(urldecode(json_encode(json_decode($val2), JSON_PRETTY_PRINT | 256))) . '</code>';
    } else if (matchSearch($val, '/image/')) {
        return '<img src="' . $val2 . '"style="width: 45%;">';
    } else if (matchSearch($val, '/location/')) {
        return null;
    } else if (matchSearch($val, '/video/')) {
        return '<video style="width: 45%;" controls><source src="' . $val2 . '" type="video/' . explode('.', $val2)[count(explode('.', $val2)) - 1] . '" /></video>';
    } else if (matchSearch($val, '/audio/')) {
        return '<audio style="width: 45%;" controls><source src="' . $val2 . '" type="audio/' . explode('.', $val2)[count(explode('.', $val2)) - 1] . '" /></audio>';
    } else {
        return empty($val2) ? '本API为网页' : $val2;
    }
}


/**
 * 处理代码示例(doc页面)
 * @param string $val 原返回类型
 * @return string 返回HTML实体
 */
function handleCodeTemp($val)
{
    if (matchSearch($val, '/image/') || matchSearch($val, '/video/') || matchSearch($val, '/audio/')) {
        return '本API为直接返回图片/视频/音频/文件';
    } else if (matchSearch($val, '/location/')) {
        return '本API为网页';
    } else {
        return '';
    }
}


/**
 * 渲染参数表格(docy页面)
 * @return string $table 返回表格的HTML实体
 */
function renderParTable($parArray, $col = 2)
{
    if (gettype($parArray) != 'array') {
        $parArray = [];
        for ($a = 0; $a < $col; $a++) {
            array_push($parArray, '无');
        }
        $parArray = [$parArray];
    }
    $table = '';

    // 这里的代码写得非常早,所以就没有用foreach的方法
    for ($init = 0; $init < count($parArray); $init++) {
        $par = $parArray[$init];
        $line = '';
        for ($a = 0; $a < $col; $a++) {
            $line = $line . '<td>' . $par[$a] . '</td>';
        }

        $table = $table . '<tr>' . $line . '</tr>';
    }
    return $table;
}


/**
 * 输出前端控制台信息
 */
function statement()
{
    consolelog('`%c欢迎访问HULIAPI %chttp://api.imlolicon.tk`, `color:yellow; background:RGB(45,238,241); font-size:25px;`, `background:RGB(247,247,247); font-size:25px`');
    consolelog('`
    _______                   _______   ______  __      __  __    __  ________  __    __  __    __ 
    /       \                 /       \ /      |/  \    /  |/  |  /  |/        |/  |  /  |/  |  /  |
    $$$$$$$  | __    __       $$$$$$$  |$$$$$$/ $$  \  /$$/ $$ |  $$ |$$$$$$$$/ $$ |  $$ |$$ |  $$ |
    $$ |__$$ |/  |  /  |      $$ |__$$ |  $$ |   $$  \/$$/  $$ |  $$ |$$ |__    $$ |__$$ |$$ |  $$ |
    $$    $$< $$ |  $$ |      $$    $$<   $$ |    $$  $$/   $$ |  $$ |$$    |   $$    $$ |$$ |  $$ |
    $$$$$$$  |$$ |  $$ |      $$$$$$$  |  $$ |     $$$$/    $$ |  $$ |$$$$$/    $$$$$$$$ |$$ |  $$ |
    $$ |__$$ |$$ \__$$ |      $$ |__$$ | _$$ |_     $$ |    $$ \__$$ |$$ |_____ $$ |  $$ |$$ \__$$ |
    $$    $$/ $$    $$ |      $$    $$/ / $$   |    $$ |    $$    $$/ $$       |$$ |  $$ |$$    $$/ 
    $$$$$$$/   $$$$$$$ |      $$$$$$$/  $$$$$$/     $$/      $$$$$$/  $$$$$$$$/ $$/   $$/  $$$$$$/  
            /  \__$$ |                                                                            
            $$    $$/                                                                             
            $$$$$$/                                                                              
    `');
    consolelog('`欢迎使用HULICore核心系统 作者:Biyuehu 版本:' . HULICORE_INFO_VERSION . '\n网站主题:' . Controller::$data['WEB_INFO']['theme'] . ' 作者:' . Controller::$data['THEME_INFO']['info']['author'] . '`');
}


/**
 * 获取网站下的所有主题列表
 * @param string $dir 主题根目录 默认USR/theme
 * @return array 返回所有主题的根目录文件夹名字(标识ID)
 */
function getAllThemes($dir = HULICORE_USR_PATH . '/theme')
{
    $files = getAlldirs($dir);
    $themes = array();
    foreach ($files as $val) {
        $path = $dir . '/' . $val . '/_manifest.php';
        if (file_exists($path)) {
            $data = include($path);
            if (gettype($data) == 'array') {
                $data['header']['type'] != 'theme' || $themes[$val] = $data;
            }
        }
    }
    return $themes;
}


/**
 * 处理参数字符串 将使用|与,分割数据的字符串转成二维数组
 * @param string
 * @return array|null
 */
function handleParStr($str)
{
    if (!empty($str)) {
        $str = explode('|', $str);
        $result = [];
        foreach ($str as $val) {
            $result2 = [];
            foreach (explode('&', $val) as $value) {
                array_push($result2, $value);
            }
            array_push($result, $result2);
        }
        return $result;
    }
}
