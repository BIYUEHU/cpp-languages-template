<?php
/**
 *
 * 音乐搜索器 - 函数声明
 *
 * @author  MaiCong <i@maicong.me>
 * @link    https://github.com/maicong/music
 * @since   1.6.2
 *
 */

// 非我族类
if (!defined('MC_CORE')) {
    header("Location: /");
    exit();
}

// 显示 PHP 错误报告
error_reporting(MC_DEBUG);

// 引入 Autoloader
require MC_CORE_DIR . '/autoloader.php';
Autoloader::register();

// Curl 内容获取
function mc_curl($args = [])
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
    if(strpos($args['url'],'service.5sing.kugou.com')===false){
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
    if (!$curl->error) {
        return $curl->rawResponse;
    }
}

// 判断地址是否有误
function mc_is_error($url) {
    $curl = new \Curl\Curl();
    $curl->setUserAgent('Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.50 Safari/537.36');
    $curl->head($url);
    $curl->close();
    return $curl->errorCode;
}


// 获取音频信息 - 关键词搜索
function mc_get_song_by_name($query, $site = 'netease', $page = 1)
{
    if (!$query) {
        return;
    }
    switch ($site) {
        case '1ting':
			return \site\m1ting::search($query, $page);
        case 'baidu':
            return \site\baidu::search($query, $page);
        case 'kugou':
            return \site\kugou::search($query, $page);
        case 'kuwo':
            return \site\kuwo::search($query, $page);
        case 'qq':
            return \site\qq::search($query, $page);
        case '5singyc':
            return \site\m5sing::search($query, $page, 'yc');
        case '5singfc':
            return \site\m5sing::search($query, $page, 'fc');
        case 'migu':
            return \site\migu::search($query, $page);
        case 'lizhi':
            return \site\lizhi::search($query, $page);
        case 'qingting':
            return \site\qingting::search($query, $page);
        case 'ximalaya':
            return \site\ximalaya::search($query, $page);
        case 'kg':
            return \site\qmkg::search($query, $page);
        case 'netease':
            return \site\netease::search($query, $page);
        default:
            return false;
    }
}

// 获取音频信息 - 歌曲ID
function mc_get_song_by_id($songid, $site = 'netease')
{
    if (empty($songid) || empty($site)) {
        return;
    }
    switch ($site) {
        case '1ting':
            return \site\m1ting::getSong($songid);
        case 'baidu':
            return \site\baidu::getSong($songid);
        case 'kugou':
            return \site\kugou::getSong($songid);
        case 'kuwo':
            return \site\kuwo::getSong($songid);
        case 'qq':
            return \site\qq::getSong($songid);
        case '5singyc':
            return \site\m5sing::getSong($songid,'yc');
        case '5singfc':
            return \site\m5sing::getSong($songid,'fc');
        case 'migu':
            return \site\migu::getSong($songid);
        case 'lizhi':
            return \site\lizhi::getSong($songid);
        case 'qingting':
            return \site\qingting::getSong($songid);
        case 'ximalaya':
            return \site\ximalaya::getSong($songid);
        case 'kg':
            return \site\qmkg::getSong($songid);
        case 'netease':
            return \site\netease::getSong($songid);
        default:
            return false;
    }
}

// 获取音频信息 - url
function mc_get_song_by_url($url)
{
    preg_match('/music\.163\.com\/(#(\/m)?|m)\/song(\?id=|\/)(\d+)/i', $url, $match_netease);
    preg_match('/(www|m)\.1ting\.com\/(player\/.*\/player_|#\/song\/)(\d+)/i', $url, $match_1ting);
    preg_match('/music\.taihe\.com\/song\/T(\d+)/i', $url, $match_baidu);
    preg_match('/(m|www)\.kugou\.com\/(play\/info\/|song\/\#hash\=)([a-z0-9]+)/i', $url, $match_kugou);
    preg_match('/(www|m)\.kuwo\.cn\/(yinyue|my|play_detail|newh5app\/play_detail)\/(\d+)/i', $url, $match_kuwo);
    preg_match('/(y\.qq\.com\/n\/yqq\/song\/|data\.music\.qq\.com\/playsong\.html\?songmid=)([a-zA-Z0-9]+)/i', $url, $match_qq);
    preg_match('/(www|m)\.xiami\.com\/song\/([a-zA-Z0-9]+)/i', $url, $match_xiami);
    preg_match('/5sing\.kugou\.com\/(m\/detail\/|)yc(-|\/)(\d+)/i', $url, $match_5singyc);
    preg_match('/5sing\.kugou\.com\/(m\/detail\/|)fc(-|\/)(\d+)/i', $url, $match_5singfc);
    preg_match('/music\.migu\.cn(\/(#|v3\/music))?\/song\/([a-zA-Z0-9]+)/i', $url, $match_migu);
    preg_match('/(www|m)\.lizhi\.fm\/(\d+)\/(\d+)/i', $url, $match_lizhi);
    preg_match('/(www|m)\.qingting\.fm\/(channels|vchannels)\/(\d+)\/programs\/(\d+)/i', $url, $match_qingting);
    preg_match('/(www|m)\.ximalaya\.com\/(\d+)\/sound\/(\d+)/i', $url, $match_ximalaya);
    preg_match('/kg\d?\.qq\.com\/.*s=([a-zA-Z0-9_-]+)&/i', $url, $match_kg_id);
    preg_match('/kg\d?\.qq\.com\/.*personal\?uid=([a-z0-9_-]+)/i', $url, $match_kg_uid);
    if (!empty($match_netease)) {
        $songid   = $match_netease[4];
        $songtype = 'netease';
    } elseif (!empty($match_1ting)) {
        $songid   = $match_1ting[3];
        $songtype = '1ting';
    } elseif (!empty($match_baidu)) {
        $songid   = 'T'.$match_baidu[1];
        $songtype = 'baidu';
    } elseif (!empty($match_kugou)) {
        $songid   = $match_kugou[3];
        $songtype = 'kugou';
    } elseif (!empty($match_kuwo)) {
        $songid   = $match_kuwo[3];
        $songtype = 'kuwo';
    } elseif (!empty($match_qq)) {
        $songid   = $match_qq[2];
        $songtype = 'qq';
    } elseif (!empty($match_xiami)) {
        $songid   = $match_xiami[2];
        $songtype = 'xiami';
    } elseif (!empty($match_5singyc)) {
        $songid   = $match_5singyc[3];
        $songtype = '5singyc';
    } elseif (!empty($match_5singfc)) {
        $songid   = $match_5singfc[3];
        $songtype = '5singfc';
    } elseif (!empty($match_migu)) {
        $songid   = $match_migu[3];
        $songtype = 'migu';
    } elseif (!empty($match_lizhi)) {
        $songid   = $match_lizhi[3];
        $songtype = 'lizhi';
    } elseif (!empty($match_qingting)) {
        $songid   = $match_qingting[3].'|'.$match_qingting[4];
        $songtype = 'qingting';
    } elseif (!empty($match_ximalaya)) {
        $songid   = $match_ximalaya[3];
        $songtype = 'ximalaya';
    }  elseif (!empty($match_kg_id)) {
        $songid   = $match_kg_id[1];
        $songtype = 'kg';
    }  elseif (!empty($match_kg_uid)) {
        return mc_get_song_by_name($match_kg_uid[1], 'kg');
    } else {
        return;
    }
    return mc_get_song_by_id($songid, $songtype);
}

function getRandom($len = 16)
{
	$str = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
	$strlen = strlen($str);
	$randstr = "";
	for ($i = 0; $i < $len; $i++) {
		$randstr .= $str[mt_rand(0, $strlen - 1)];
	}
	return $randstr;
}

// Server
function server($key)
{
    return isset($_SERVER[$key]) ? $_SERVER[$key] : null;
}

// Post
function post($key)
{
    return isset($_POST[$key]) ? $_POST[$key] : null;
}

// Response
function response($data, $code = 200, $error = '')
{
    header('Content-type:text/json; charset=utf-8');
    echo json_encode(array(
        'data'  => $data,
        'code'  => $code,
        'error' => $error
    ));
    exit();
}
