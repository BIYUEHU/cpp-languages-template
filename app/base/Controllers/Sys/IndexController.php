<?php

namespace Base\Controllers\Sys;

use Base\Controllers\Controller;
use Lib\CaptchaImg;
use function Core\Func\location;
use function Base\Controllers\getAllThemes;

class IndexController extends Controller
{
    /**
     * 获取主题图标
     */
    public function getthemeicon()
    {
        $val = $_REQUEST['theme'];
        $themeList = getAllThemes();
        if (!empty($themeList[$val])) {
            $icon = $themeList[$val]['header']['icon'];
            if (!empty($icon)) {
                preg_match_all('/\/\//', $icon, $data);
                if (empty($data[0])) {
                    header('Content-Type: image/png');
                    echo file_get_contents(HULICORE_USR_PATH . '/theme/' . $val . '/' . $icon);
                } else {
                    location($icon);
                }
            }
        }
        exit();
    }


    /**
     * 获取用户头像
     */
    public function getaccountavatar()
    {
        $val = $_REQUEST['id'] ?? self::$data['VERIFY']['id'];
        $filePath = HULICORE_DATA_PATH . "/account/{$val}.png";
        if (file_exists($filePath) == true) {
            header('Content-type: image/png');
            echo file_get_contents($filePath);
        } else {
            location("/images/api_2.png");
        }
        exit();
    }


    /**
     * 随机验证码图片
     */
    public function captchaimg()
    {
        require(HULICORE_LIB_PATH . '/captchaimg.class.php');
        CaptchaImg::spawn();
        exit();
    }


    /**
     * 数据统计
     */
    public function datastat()
    {
        $childSite = self::childSiteData();

        $data = array(
            'numapi' => self::numApiData(),
            'call' => self::callData(),
            'callavg' => self::callDataAvg(self::$data['WEB_INFO']['createtime']),
            'visit' => self::visitWebData(),
            'visitor' => self::visitorWebData()
        );
        $childSite && $data = array_merge($data, ['child' => $childSite]);

        if ($_REQUEST['format'] == 'text') {
            $result = '接口数据';
            $result .= "\n总计：{$data['numapi']['total']}";
            $result .= "\n正常：{$data['numapi']['well']}";
            $result .= "\n维护：{$data['numapi']['bad']}";
            $result .= "\n外链：{$data['numapi']['out']}";
            $result .= "\n隐藏：{$data['numapi']['hide']}";
            $result .= "\n调用数据";
            $result .= "\n总计：{$data['call']['total']}";
            $result .= "\n今日：{$data['call']['today']}";
            $result .= "\n昨日：{$data['call']['yesterday']}";
            $result .= "\n平均调用数据";
            $result .= "\n每月：{$data['callavg']['mouth']}";
            $result .= "\n每周：{$data['callavg']['week']}";
            $result .= "\n每日：{$data['callavg']['day']}";
            $result .= "\n每时：{$data['callavg']['hour']}";
            $result .= "\n访问数据";
            $result .= "\n总计：{$data['visit']['total']}";
            $result .= "\n今日：{$data['visit']['today']}";
            $result .= "\n昨日：{$data['visit']['yesterday']}";
            $result .= "\n访客数据";
            $result .= "\n总计：{$data['visitor']['total']}";
            $result .= "\n今日：{$data['visitor']['today']}";
            $result .= "\n昨日：{$data['visitor']['yesterday']}";
            if ($data['child']) {
                $result .= "\n子站信息";
                $result .= "\n数量：" . $data['child']['num'];
                $result .= "\n列表：";
                foreach ($data['child']['list'] as $val) {
                    $result .= "\n" . $val;
                }
            };


            header('Content-type: text/plain');
            echo $result;
        } else {
            self::printResult(500, $data);
        }
    }
}
