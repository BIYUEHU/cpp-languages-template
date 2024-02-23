<?php
// 咪咕音乐

namespace site;

class migu
{
    
    public static function search($query, $page)
    {
        if (empty($query)) {
            return;
        }
        $radio_search_url = [
            'method'         => 'GET',
            'url'            => 'http://m.music.migu.cn/migu/remoting/scr_search_tag',
            'referer'        => 'http://m.music.migu.cn',
            'proxy'          => false,
            'body'           => [
                'keyword'    => $query,
                'type'       => '2',
                'pgc'        => $page,
                'rows'       => 10
            ],
            'user-agent'    => 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1'
        ];
        $radio_result = mc_curl($radio_search_url);
        if (empty($radio_result)) {
            return;
        }
        $radio_data = json_decode($radio_result, true);
        if (empty($radio_data['musics'])) {
            return;
        }
        foreach ($radio_data['musics'] as $value) {
            $radio_song_id = $value['copyrightId'];
            $radio_author  = $value['singerName'];
            //$radio_url  = self::getSongUrl($radio_song_id);
            if ($value['lyrics']) {
                $radio_lrc  = self::getLyric($radio_song_id);
            }
            $radio_songs[] = [
                'type'   => 'migu',
                'link'   => 'https://music.migu.cn/v3/music/song/'.$radio_song_id,
                'songid' => $radio_song_id,
                'title'  => $value['songName'],
                'author' => $value['singerName'],
                'lrc'    => $radio_lrc,
                'url'    => $value['mp3'],
                'pic'    => $value['cover']
            ];
        }
        return $radio_songs;
    }

    public static function getSong($songid, $self = false)
    {
        if (empty($songid)) {
            return;
        }
        $radio_song_url = [
            'method'        => 'GET',
            'url'           => 'http://m.music.migu.cn/migu/remoting/cms_detail_tag',
            'referer'       => 'http://m.music.migu.cn/v3/music/song/'.$songid,
            'proxy'         => false,
            'body'          => [
				'cpid' => $songid,
			],
            'user-agent'    => 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1'
        ];
        $radio_result = mc_curl($radio_song_url);
        if (empty($radio_result)) {
            return;
        }
        $radio_json = json_decode($radio_result, true);
        $radio_data = $radio_json['data'];
        $radio_songs = [];
        if (!empty($radio_data)) {
            $radio_song_id = $radio_data['copyrightId'];
            $radio_author  = implode(',', $radio_data['singerName']);
            //$radio_url  = self::getSongUrl($radio_song_id);
            $radio_songs = [
                'type'   => 'migu',
                'link'   => 'https://music.migu.cn/v3/music/song/' . $radio_song_id,
                'songid' => $radio_song_id,
                'title'  => $radio_data['songName'],
                'author' => $radio_author,
                'lrc'    => $radio_data['lyricLrc'],
                'url'    => $radio_data['listenUrl'],
                'pic'    => $radio_data['picS']
            ];
            return $self ? $radio_songs : [$radio_songs];
        }else{
            return;
        }
    }

    public static function getLyric($songid)
    {
        $radio_lrc_url = [
            'method'        => 'GET',
            'url'           => 'http://music.migu.cn/v3/api/music/audioPlayer/getLyric',
            'referer'       => 'http://music.migu.cn/v3/music/player/audio',
            'proxy'         => false,
            'body'          => [
				'copyrightId' => $songid,
			]
        ];
        $radio_result = mc_curl($radio_lrc_url);
        $arr = json_decode($radio_result, true);
        return isset($arr['lyric'])?$arr['lyric']:false;
    }

    public static function getSongUrl($songid)
    {
        $radio_song_url = [
            'method'        => 'GET',
            'url'           => 'http://music.migu.cn/v3/api/music/audioPlayer/getPlayInfo',
            'referer'       => 'http://music.migu.cn/v3/music/player/audio',
            'proxy'         => false,
            'body'          => self::encode_migu_data([
				'copyrightId' => $songid,
			])
        ];
        $radio_result = mc_curl($radio_song_url);
        $arr = json_decode($radio_result, true);
        if($arr['returnCode']=='000000'){
            return $arr['data']['hqPlayInfo']['playUrl'] ?: $arr['data']['bqPlayInfo']['playUrl'];
        }else{
            return false;
        }
    }

    private static function migu_derive($password, $salt, $keyLength, $ivSize){
        $keySize = $keyLength / 8;
        $repeat = ceil(($keySize + $ivSize * 8) / 32);
        $result = array();
        for($i=0;$i<$repeat;$i++){
            $result[] = md5(hex2bin(end($result)).$password.$salt);
        }
        $buffer = hex2bin(implode($result));
        return array('key'=>substr($buffer,0,$keySize), 'iv'=>substr($buffer,$keySize,$ivSize));
    }
    // 加密咪咕音乐 api 参数
    private static function encode_migu_data($data)
    {
        $data = json_encode($data);
        $password = bin2hex(getRandom(32));
        $salt = getRandom(8);
        $publicKey = "-----BEGIN PUBLIC KEY-----\nMIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQC8asrfSaoOb4je+DSmKdriQJKWVJ2oDZrs3wi5W67m3LwTB9QVR+cE3XWU21Nx+YBxS0yun8wDcjgQvYt625ZCcgin2ro/eOkNyUOTBIbuj9CvMnhUYiR61lC1f1IGbrSYYimqBVSjpifVufxtx/I3exReZosTByYp4Xwpb1+WAQIDAQAB\n-----END PUBLIC KEY-----";
        $secret = self::migu_derive($password, $salt, 256, 16);
        $data = openssl_encrypt($data, 'aes-256-cbc', $secret['key'], 1, $secret['iv']);
        openssl_public_encrypt($password, $secKey, $publicKey);
        $data = base64_encode('Salted__'.$salt.$data);
        $secKey = base64_encode($secKey);
        return array('dataType' => 2, 'data' => $data, 'secKey' => $secKey);
    }

}