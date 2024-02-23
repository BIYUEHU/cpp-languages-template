<?php
// 网易云音乐

namespace site;

class netease
{
    
    public static function search($query, $page)
    {
        if (empty($query)) {
            return;
        }
        $radio_search_url = [
            'method'         => 'POST',
            'url'            => 'http://music.163.com/api/linux/forward',
            'referer'        => 'http://music.163.com/',
            'proxy'          => false,
            'body'           => self::encode_netease_data([
                'method'     => 'POST',
                'url'        => 'http://music.163.com/api/cloudsearch/pc',
                'params'     => [
                    's'      => $query,
                    'type'   => 1,
                    'offset' => $page * 10 - 10,
                    'limit'  => 10
                ]
            ])
        ];
        $radio_result = mc_curl($radio_search_url);
        if (empty($radio_result)) {
            return;
        }
        $radio_songid = [];
        $radio_data = json_decode($radio_result, true);
        if (empty($radio_data['result']) || empty($radio_data['result']['songs'])) {
            return;
        }
        $radio_songs = [];
        foreach ($radio_data['result']['songs'] as $value) {
            $radio_song_id       = $value['id'];
            $radio_authors       = [];
            foreach ($value['ar'] as $key => $val) {
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

    public static function getSong($songid, $multi = false)
    {
        if (empty($songid)) {
            return;
        }
        if ($multi) {
            if (!is_array($songid)) {
                return;
            }
            $songid = implode(',', $songid);
        }
        $radio_song_url = [
            'method'        => 'POST',
            'url'           => 'http://music.163.com/api/linux/forward',
            'referer'       => 'http://music.163.com/',
            'proxy'         => false,
            'body'          => self::encode_netease_data([
                'method'    => 'GET',
                'url'       => 'http://music.163.com/api/song/detail',
                'params'    => [
                  'id'      => $songid,
                  'ids'     => '[' . $songid . ']'
                ]
            ])
        ];
        $radio_result = mc_curl($radio_song_url);
        if (empty($radio_result)) {
            return;
        }
        $radio_songs = [];
        $radio_urls = self::getSongUrl($songid);
        /*if (MC_INTERNAL) {
            $radio_urls = self::getSongUrl($songid);
        }*/
        $radio_json                  = json_decode($radio_result, true);
        $radio_data                  = $radio_json['songs'];
        if (!empty($radio_data)) {
            foreach ($radio_data as $value) {
                $radio_song_id       = $value['id'];
                $radio_authors       = [];
                foreach ($value['artists'] as $key => $val) {
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
                    'pic'    => $value['album']['picUrl'] . '?param=300x300'
                ];
            }
            return $radio_songs;
        }else{
            return;
        }
    }

    private static function getSongUrl($songid)
    {
        $radio_streams                   = [
            'method'      => 'POST',
            'url'         => 'http://music.163.com/api/linux/forward',
            'referer'     => 'http://music.163.com/',
            'proxy'       => false,
            'body'        => self::encode_netease_data([
                'method'  => 'POST',
                'url'     => 'http://music.163.com/api/song/enhance/player/url',
                'params'  => [
                    'ids' => is_array($songid) ? $songid : [$songid],
                    'br'  => 320000,
                ]
            ])
        ];
        $radio_info                      = json_decode(mc_curl($radio_streams), true);
        $radio_urls                      = [];
        if (!empty($radio_info['data'])) {
            foreach ($radio_info['data'] as $val) {
                $radio_urls[$val['id']]  = $val['url'];
            }
        }
        return $radio_urls;
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
        $radio_result = mc_curl($radio_lrc_url);
        $arr = json_decode($radio_result, true);
        return isset($arr['lrc']['lyric']) ? $arr['lrc']['lyric'] : null;
    }

    // 加密网易云音乐 api 参数 APP接口
    private static function encode_netease_data($data)
    {
        $_key = 'rFgB&h#%2?^eDg:Q';
        $data = json_encode($data);
        $data = openssl_encrypt($data, 'aes-128-ecb', $_key);
        $data = strtoupper(bin2hex(base64_decode($data)));
        return ['eparams' => $data];
    }

    // 加密网易云音乐 api 参数 网页版接口
    private static function encode_netease_data2($data)
    {
        $data = json_encode($data);
        $iv = '0102030405060708';
        $presetKey = '0CoJUm6Qyw8W8jud';
        $publicKey = "-----BEGIN PUBLIC KEY-----\nMIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDgtQn2JZ34ZC28NWYpAUd98iZ37BUrX/aKzmFbt7clFSs6sXqHauqKWqdtLkF2KexO40H1YTX8z2lSgBBOAxLsvaklV8k4cBFK9snQXE9/DDaFt6Rr7iVZMldczhC0JNgTz+SHXT6CBHuX3e9SdB1Ua44oncaTWz7OBGLbCiK45wIDAQAB\n-----END PUBLIC KEY-----";
        $secretKey = getRandom(16);
        $data = openssl_encrypt($data, 'aes-128-cbc', $presetKey, 1, $iv);
        $data = openssl_encrypt(base64_encode($data), 'aes-128-cbc', $secretKey, 1, $iv);
        $params = base64_encode($data);

        $buffer = strrev($secretKey);
        $buffer = str_pad($buffer,128,"\0",STR_PAD_LEFT);
        openssl_public_encrypt($buffer, $encSecKey, $publicKey, OPENSSL_NO_PADDING);
        $encSecKey = bin2hex($encSecKey);
        return array('params' => $params, 'encSecKey' => $encSecKey);
    }
}