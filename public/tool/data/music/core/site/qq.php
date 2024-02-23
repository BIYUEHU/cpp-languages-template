<?php
// QQ音乐

namespace site;

class qq
{
    
    public static function search($query, $page)
    {
        if (empty($query)) {
            return;
        }
        $radio_search_url = [
            'method'         => 'GET',
            'url'            => 'https://shc6.y.qq.com/soso/fcgi-bin/search_for_qq_cp',
            'referer'        => 'https://m.y.qq.com',
            'proxy'          => false,
            'body'           => [
                'w'          => $query,
                'p'          => $page,
                'n'          => 10,
                'format'     => 'json'
            ],
            'user-agent'     => 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1'
        ];
        $radio_result = mc_curl($radio_search_url);
        if (empty($radio_result)) {
            return;
        }
        $radio_songid = [];
        $radio_data = json_decode($radio_result, true);
        if (empty($radio_data['data']) || empty($radio_data['data']['song']) || empty($radio_data['data']['song']['list'])) {
            return;
        }
        foreach ($radio_data['data']['song']['list'] as $val) {
            if($val['pay']['payplay']==1)continue;
            $radio_songid[] = $val['songmid'];
        }
        $radio_urls = self::getSongUrl($radio_songid, true);
        $radio_songs = [];
        $i=0;
        foreach ($radio_data['data']['song']['list'] as $value) {
            if($value['pay']['payplay']==1)continue;
            $radio_song_id       = $value['songmid'];
            $radio_authors       = [];
            foreach ($value['singer'] as $singer) {
                $radio_authors[] = $singer['name'];
            }
            $radio_author        = implode(',', $radio_authors);
            $radio_lrc = self::getLyric($radio_song_id);
            $radio_music         = $radio_urls[$i];
            $radio_album_id      = $value['albummid'];
            $radio_songs[]       = [
                'type'   => 'qq',
                'link'   => 'https://y.qq.com/n/yqq/song/' . $radio_song_id . '.html',
                'songid' => $radio_song_id,
                'title'  => $value['songname'],
                'author' => $radio_author,
                'lrc'    => $radio_lrc,
                'url'    => $radio_music,
                'pic'    => 'https://y.gtimg.cn/music/photo_new/T002R300x300M000' . $radio_album_id . '.jpg'
            ];
            $i++;
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
            $songids = implode(',', $songid);
        }else{
            $songids = $songid;
        }
        $radio_song_url = [
            'method'        => 'GET',
            'url'           => 'https://c.y.qq.com/v8/fcg-bin/fcg_play_single_song.fcg',
            'referer'       => 'https://m.y.qq.com',
            'proxy'         => false,
            'body'          => [
                'songmid'   => $songids,
                'format'    => 'json'
            ],
            'user-agent'    => 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1'
        ];
        $radio_result = mc_curl($radio_song_url);
        if (empty($radio_result)) {
            return;
        }
        $radio_songs = [];
        $radio_json                  = json_decode($radio_result, true);
        $radio_data                  = $radio_json['data'];
        if (!empty($radio_data)) {
            $radio_urls = self::getSongUrl($songid, $multi);
            foreach ($radio_data as $i=>$value) {
                if ($value['pay']['pay_play']==1) {
                    if (!$multi) {
                        $radio_songs      = [
                            'error' => '源站反馈此音频需要付费',
                            'code' => 403
                        ];
                        return $radio_songs;
                    }
                    continue;
                }
                $radio_song_id       = $value['mid'];
                $radio_authors       = [];
                foreach ($value['singer'] as $singer) {
                    $radio_authors[] = $singer['title'];
                }
                $radio_author        = implode(',', $radio_authors);
                $radio_lrc = self::getLyric($radio_song_id);
                $radio_music         = $radio_urls[$i];
                $radio_album_id      = $value['album']['mid'];
                $radio_songs[]       = [
                    'type'   => 'qq',
                    'link'   => 'https://y.qq.com/n/yqq/song/' . $radio_song_id . '.html',
                    'songid' => $radio_song_id,
                    'title'  => $value['title'],
                    'author' => $radio_author,
                    'lrc'    => $radio_lrc,
                    'url'    => $radio_music,
                    'pic'    => 'https://y.gtimg.cn/music/photo_new/T002R300x300M000' . $radio_album_id . '.jpg'
                ];
            }
            return $radio_songs;
        }else{
            return;
        }
    }

    private static function getSongUrl($songid, $multi = false){
        $guid=(string)rand(111111111,999999999);
        if ($multi) {
            foreach($songid as $row){
                $songmids[] = $row;
                $songtypes[] = 0;
            }
        }else{
            $songmids = array($songid);
            $songtypes = array(0);
        }
        $rdata = array('req'=>array('module'=>'CDN.SrfCdnDispatchServer','method'=>'GetCdnDispatch','param'=>array('guid'=>$guid,'calltype'=>0,'userip'=>'')),'req_0'=>array('module'=>'vkey.GetVkeyServer','method'=>'CgiGetVkey','param'=>array('guid'=>$guid,'songmid'=>$songmids,'songtype'=>$songtypes,'uin'=>'0','loginflag'=>1,'platform'=>'20')),'comm'=>array('uin'=>0,'format'=>'json','ct'=>24,'cv'=>0));
        $data = json_decode(mc_curl([
            'method'     => 'GET',
            'url'        => 'https://u.y.qq.com/cgi-bin/musicu.fcg',
            'referer'    => 'https://y.qq.com/portal/player.html',
            'proxy'      => false,
            'body'       => ['data'=>json_encode($rdata)]
        ]), true);
        $server_url = $data['req_0']['data']['sip'][0];
        $radio_url = [];
        if ($multi) {
            foreach($songid as $k=>$v){
                $radio_url[] = $server_url.$data['req_0']['data']['midurlinfo'][$k]['purl'];
            }
        }else{
            $radio_url[] = $server_url.$data['req_0']['data']['midurlinfo'][0]['purl'];
        }
        return $radio_url;
    }

    private static function getLyric($songid)
    {
        $radio_lrc_url = [
            'method'        => 'GET',
            'url'           => 'https://c.y.qq.com/lyric/fcgi-bin/fcg_query_lyric.fcg',
            'referer'       => 'https://m.y.qq.com',
            'proxy'         => false,
            'body'          => [
                'songmid'   => $songid,
                'format'    => 'json',
                'nobase64'  => 1,
                'songtype'  => 0,
                'callback'  => 'c'
            ],
            'user-agent'    => 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1'
        ];
        $radio_result = mc_curl($radio_lrc_url);
        $arr = self::jsonp2json($radio_result);
        return isset($arr['lyric']) ? self::str_decode($arr['lyric']) : null;
    }

    // jsonp 转 json
    private static function jsonp2json($jsonp) {
        if ($jsonp[0] !== '[' && $jsonp[0] !== '{') {
            $jsonp = mb_substr($jsonp, mb_strpos($jsonp, '('));
        }
        $json = trim($jsonp, "();");
        if ($json) {
            return json_decode($json, true);
        }
    }

    // 去除字符串转义
    private static function str_decode($str) {
        $str = str_replace(['&#13;', '&#10;'], ['', "\n"], $str);
        $str = html_entity_decode($str, ENT_QUOTES, 'UTF-8');
        return $str;
    }
}