<?php
/*
 * @Author: Biyuehu
 * @Blog: http://hotaru.icu
 * @Date: 2023-02-16 16:12:33
 */

require(__dir__ . './src/Curl/Curl.php');

function curlSuper($args = [])
{
    $default = [
        'method'     => 'GET',
        'user-agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.50 Safari/537.36',
        'url'        => null,
        'referer'    => null,
        'headers'    => null,
        'body'       => null,
        'proxy'      => false
    ];
    $args         = array_merge($default, $args);
    $method       = mb_strtolower($args['method']);
    $method_allow = ['get', 'post'];
    if (null === $args['url'] || !in_array($method, $method_allow, true)) {
        return;
    }
    $curl = new \Curl\Curl();
    $curl->setUserAgent($args['user-agent']);
    $curl->setReferrer($args['referer']);
    $curl->setTimeout(15);
    $curl->setHeader('X-Requested-With', 'XMLHttpRequest');
    $curl->setOpt(CURLOPT_FOLLOWLOCATION, true);
    $curl->setOpt(CURLOPT_SSL_VERIFYPEER, false);
    $curl->setOpt(CURLOPT_SSL_VERIFYHOST, false);
    if (strpos($args['url'], 'service.5sing.kugou.com') === false) {
        $curl->setOpt(CURLOPT_ENCODING, 'gzip');
    }
    if ($args['proxy'] && MC_PROXY) {
        $curl->setOpt(CURLOPT_HTTPPROXYTUNNEL, 1);
        $curl->setOpt(CURLOPT_PROXY, MC_PROXY);
        $curl->setOpt(CURLOPT_PROXYUSERPWD, MC_PROXYUSERPWD);
    }
    if (!empty($args['headers'])) {
        $curl->setHeaders($args['headers']);
    }
    $curl->$method($args['url'], $args['body']);
    $curl->close();
    // var_dump($curl);
    if (!$curl->error) {
        return $curl->rawResponse;
    }
}
function get_curl($url, $post = 0, $referer = 0, $cookie = 0, $header = 0, $ua = 0, $nobaody = 0)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $httpheader[] = "Accept:*/*";
        $httpheader[] = "Accept-Encoding:gzip,deflate,sdch";
        $httpheader[] = "Accept-Language:zh-CN,zh;q=0.8";
        $httpheader[] = "Connection:close";
        curl_setopt($ch, CURLOPT_HTTPHEADER, $httpheader);
        if ($post) {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        }
        if ($header) {
            curl_setopt($ch, CURLOPT_HEADER, true);
        }
        if ($cookie) {
            curl_setopt($ch, CURLOPT_COOKIE, $cookie);
        }
        if ($referer) {
            if ($referer == 1) {
                curl_setopt($ch, CURLOPT_REFERER, 'http://bilibili.com/');
            } else {
                curl_setopt($ch, CURLOPT_REFERER, $referer);
            }
        }
        if ($ua) {
            curl_setopt($ch, CURLOPT_USERAGENT, $ua);
        } else {
            curl_setopt($ch, CURLOPT_USERAGENT, "MQQBrowser/Mini3.1 (Nokia3050/MIDP2.0)");
        }
        if ($nobaody) {
            curl_setopt($ch, CURLOPT_NOBODY, 1);
        }
        curl_setopt($ch, CURLOPT_ENCODING, "gzip");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $ret = curl_exec($ch);
        curl_close($ch);
        return $ret;
    }


class Component {
    private static $UID;
    private static $FORMAT;
    private static $TEXT;
    private static $data = array(
        'tag' => array(),
        'color' => array()
    );
    private static $captor;
    private static $defaultTag;

    public function __construct($uid, $format = 'json')
    {
        self::$UID = $uid;
        self::$FORMAT = $format == 'html' ? 'html' : 'json';
        header('Content-type: ' . (self::$FORMAT == 'html' ? 'text/html' : 'application/json'));

        $code = empty(self::$UID) ? 501 : self::runEvent();
        if ($code !== false) {
            $result = array(
                'code' => $code,
                'message' => $code == 500 ? 'success' : 'error',
                'data' => self::$data
            );
            echo stripslashes(json_encode($result, 256));
        }
    }

    private function runEvent()
    {
        $tempData = self::definedData();
        self::$captor = $tempData[0];
        self::$defaultTag = $tempData[1];
        // self::$TEXT = file_get_contents('https://api.bilibili.com/x/polymer/web-dynamic/v1/feed/space?&host_mid=' . self::$UID);
        echo get_curl('https://api.bilibili.com/x/polymer/web-dynamic/v1/feed/space?offset=&host_mid=293767574&timezone_offset=-480&features=itemOpusStyle');
        
        // self::$TEXT = \Core\Func\get_url('https://api.bilibili.com/x/polymer/web-dynamic/v1/feed/space?&host_mid=' . self::$UID);
        exit();
        // return self::handel();
    }

    private static function searchStr($rule)
    {
        $ruleAnd = explode('&', $rule);
        $trueNum = 0;
        foreach ($ruleAnd as $rule2) {
            $ruleOr = explode('|', $rule2);
            foreach ($ruleOr as $rule3) {
                if ((substr($rule3, 0, 1) == '!' && empty(strpos(self::$TEXT, substr($rule3, 1)))) || (substr($rule3, 0, 1) != '!' && !empty(strpos(self::$TEXT, $rule3)))) {
                    $trueNum++;
                    // echo $rule . '>>' . $rule2 . '>>' . $rule3 . ' ONE:' . ((substr($rule3, 0, 1) === '!' && strpos(self::$TEXT, $rule3) == false)) . ' SECO: ' . (substr($rule3, 0, 1) != '!' && !empty(strpos(self::$TEXT, $rule3))) . ' <br>';
                } else {
                    // return false;
                }
            };
        }
        return $trueNum >= count($ruleAnd);
    }

    private static function spawnHtml($data)
    {
        return "<b style='color: {$data[1]}' >{$data[0]}</b>";
    }

    private static function handel()
    {
        $result = $isof = false;
        $html = '<span id="huli">';
        foreach (self::$captor as $val) {
            
            $isof = false;
            $captorName = $val[0];
            $arr = $val[1] ?? '#000000';
            $captorColor = $val[2];
            $init = 0;

            foreach ($arr as $tempArr) {
                $init++;
                $viewName = $tempArr[0];
                $keyword = empty($tempArr[1]) ? $viewName : $tempArr[1];
                $color = $tempArr[2];
                if (self::searchStr($keyword)) {
                    $result = true;
                    if (self::$FORMAT == 'html') {
                        if ($captorName) {
                            $isof || ($html .= "<b style='color: {$captorColor}' > 【 {$captorName}  ");
                            $isof = true;
                            $html .= "| </b> <b style='color: {$color}'> {$viewName}</b>";
                        } else {
                            $html .= self::spawnHtml([$viewName, $color]);
                        }
                    } else {
                        array_push(self::$data['tag'], $viewName);
                        array_push(self::$data['color'], $color);
                    }
                }
                self::$FORMAT == 'html' && $init === count($arr) - 1 && $isof && $html .= "<b style='color: {$captorColor}' >】</b>";
            }
        };

        $result || (self::$FORMAT == 'html' ? ($html .= self::spawnHtml(self::$defaultTag)) : (array_push(self::$data['tag'], self::$defaultTag[0]) && array_push(self::$data['color'], self::$defaultTag[1])));
        if (self::$FORMAT == 'html') {
            echo $html . '</span>';
            return false;
        }
        return 500;
    }

    private function definedData() {
        $threeList = [
            ["【 传奇 | 三相之力】", "原神&明日方舟&王者荣耀", "#FFD700"],
            ["【 史诗 | 二刺螈双象限】", "原神&明日方舟&!王者荣耀", "#FF0000"],
            ["【 史诗 | 双批齐聚】", "原神&!明日方舟&王者荣耀", "#FF0000"],
            ["【 史诗 | 稀有的存在】", "!原神&明日方舟&王者荣耀", "#FF0000"],
            ["【 稀有 | 原批】", "原神&!明日方舟&!王者荣耀", "#6600CC"],
            ["【 稀有 | 粥畜】", "!原神&明日方舟&王者荣耀", "#6600CC"],
            ["【 稀有 | 农批】", "!原神&!明日方舟&王者荣耀", "#6600CC"]
        ];
    
        $vtuberList = [
            ["嘉心糖", "嘉然", "#E799B0"],
            ["雏草姬", "塔菲", "#FF00CC"],
            ["棺材板", "東雪蓮", "#C0C0C0"],
            ["杰尼", "七海", "#947583"],
            ["喵喵露", "猫雷", "#00FF00"],
            ["三畜", "小狗说", "#B8A6D9"],
            ["顶碗人", "向晚", "#9AC8E2"],
            ["贝极星", "贝拉", "#DB7D74"],
            ["奶淇琳", "乃琳", "#576690"],
            ["小星星", "星瞳", "#E0E0E0"],
            ["小孩梓", "梓", "#9900FF"]
        ];
    
        $vocaloadList = [
            ["骑士团", "初音|miku|MIKU", "#00CC99"],
            ["洛天依", "天依", "#33CCFF"]
        ];
    
        $igameList = [
            ["仙剑"],
            ["古剑"],
            ["逆水寒"],
            ["诛仙世界"],
            ["剑网"]
        ];
    
        $cgameList = [
            ["黑神话"],
            ["LOL", "英雄联盟|LOL"],
            ["COD", "使命召唤"]
        ];
    
        $ecygameList = [
            ["幻塔", null, "#FFCC66"],
            ["战双"],
            ["鸣潮"],
            ["米-零", "绝区零", "#0066FF"],
            ["米-崩", "崩坏|崩三", "#0066FF"],
            ["米-铁", "星穹铁道", "#0066FF"],
            ["光遇"],
            ["碧蓝", null, "#33CCC"],
            ["月球人", "FGO|冠位指定"],
            ["公主", "公主连结", "#CCFF99"],
            ["车万人", "东方project|灵梦|芙兰朵露|魔理沙"]
        ];
    
        $zgameList = [
            ["塞尔达"],
            ["怪猎", "怪物猎人"]
        ];
    
        $ogameList = [
            ["安慕希", "MINECRAFT|Minecraft|我的世界", "#006600"],
            ["传说之下", "UNDERTALE|undertale|Undertale|传说之下", "#333366"],
            ["SCP", null, "#330000"]
        ];
    
        $otherList = [
            ["【 隐藏 | 动态抽奖】", "抽奖", "#254680"]
        ];
    
        $defaultTag = ["【 普通 |  纯良】", "#11DD77"];
    
        // 不需要显示的注释即可
        $captor = [
            ['Vtuber', $vtuberList],
            ['', $threeList],
            ['V家', $vocaloadList],
            ['网游', $igameList, "#6666FF"],
            ['端游', $cgameList, "#6699FF"],
            ['二游', $ecygameList, "pink"],
            ['主机', $zgameList],
            ['混沌', $ogameList, "#FF6600"],
            ['', $otherList]
        ];

        return [$captor, $defaultTag];
    }
}


$uid = $_REQUEST['uid'];
$format = $_REQUEST['format'];
(new Component($uid, $format));
