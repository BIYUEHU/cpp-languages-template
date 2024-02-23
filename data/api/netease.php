<?php

require(__DIR__ . '/src/Curl/Curl.php');

class Netease
{
    public static function search($name)
    {
        $name = urlencode($name);
        $radio_result = file_get_contents("https://music.163.com/api/cloudsearch/pc?s=$name&type=1&page=0&limit=10");
        $radio_data = json_decode($radio_result, true);
        if (empty($radio_data['result']) || empty($radio_data['result']['songs'])) {
            return;
        }

        $radio_songs = [];
        foreach ($radio_data['result']['songs'] as $value) {
            $radio_song_id       = $value['id'];
            $radio_authors       = [];
            foreach ($value['ar'] as $val) {
                $radio_authors[] = $val['name'];
            }
            $radio_author        = implode(',', $radio_authors);
            $radio_lrc       = self::getLyric($radio_song_id);
            $radio_songs[]       = [
                'type'   => 'netease',
                'link'   => 'http://music.163.com/#/song?id=' . $radio_song_id,
                'songid' => $radio_song_id,
                'title'  => $value['name'],
                'author' => $radio_author,
                'lrc'    => $radio_lrc,
                'url'    => 'http://music.163.com/song/media/outer/url?id=' . $radio_song_id . '.mp3',
                'pic'    => $value['al']['picUrl'] . '?param=300x300'
            ];
        }
        return $radio_songs;
    }

    private static function getLyric($songid)
    {
        $radio_lrc_url = [
            'method'        => 'POST',
            'url'           => 'http://music.163.com/api/linux/forward',
            'referer'       => 'http://music.163.com/',
            'proxy'         => false,
            'body'          => self::encode_netease_data([
                'method'    => 'GET',
                'url'       => 'http://music.163.com/api/song/lyric',
                'params'    => [
                    'id' => $songid,
                    'lv' => 1
                ]
            ])
        ];
        $radio_result = self::mc_curl($radio_lrc_url);
        $arr = json_decode($radio_result, true);
        return isset($arr['lrc']['lyric']) ? $arr['lrc']['lyric'] : null;
    }

    private static function encode_netease_data($data)
    {
        $_key = 'rFgB&h#%2?^eDg:Q';
        $data = json_encode($data);
        $data = openssl_encrypt($data, 'aes-128-ecb', $_key);
        $data = strtoupper(bin2hex(base64_decode($data)));
        return ['eparams' => $data];
    }

    private static function mc_curl($args = [])
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
        if (!$curl->error) {
            return $curl->rawResponse;
        }
    }
}

header('Content-type: application/json');
$name = $_REQUEST['name'];
$codelist = \Core\Func\loadConfig('apicode.php');
$code = 501;
$data = [];
if (!empty($name)) {
    $data = Netease::search($_REQUEST['name']);
    $code = empty($data) ? 502 : 500;
}
echo json_encode(array(
    "code" => $code,
    "message" => $codelist[$code],
    "data" => $data
), 256);
