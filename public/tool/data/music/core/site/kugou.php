<?php
// 酷狗音乐

namespace site;

class kugou
{
    
    public static function search($query, $page)
    {
        if (empty($query)) {
            return;
        }
        $radio_search_url = [
            'method'         => 'GET',
            'url'            => MC_INTERNAL ?
                'http://songsearch.kugou.com/song_search_v2' :
                'http://mobilecdn.kugou.com/api/v3/search/song',
            'referer'        => MC_INTERNAL ? 'http://www.kugou.com' : 'http://m.kugou.com',
            'proxy'          => false,
            'body'           => [
                'keyword'    => $query,
                'platform'   => 'WebFilter',
                'format'     => 'json',
                'page'       => $page,
                'pagesize'   => 10
            ]
        ];
        $radio_result = mc_curl($radio_search_url);
        if (empty($radio_result)) {
            return;
        }
        $radio_songs = [];
        $radio_data = json_decode($radio_result, true);
        $key = MC_INTERNAL ? 'lists' : 'info';
        if (empty($radio_data['data']) || empty($radio_data['data'][$key])) {
            return;
        }
        foreach ($radio_data['data'][$key] as $val) {
            if (MC_INTERNAL) {
                $hash = $val['HQFileHash'];
                if (!str_replace('0', '', $hash)) {
                    $hash = $val['FileHash'];
                }
            } else {
                $hash = $val['320hash'] ?: $val['hash'];
            }
            $radio_song = self::getSong($hash, true);
            if(is_array($radio_song)) $radio_songs[] = $radio_song;
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
            'url'           => 'http://m.kugou.com/app/i/getSongInfo.php',
            'referer'       => 'http://m.kugou.com/play/info/' . $songid,
            'proxy'         => false,
            'body'          => [
                'cmd'       => 'playInfo',
                'hash'      => $songid
            ],
            'user-agent'    => 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1'
        ];
        $radio_result = mc_curl($radio_song_url);
        if (empty($radio_result)) {
            return;
        }
        $radio_data           = json_decode($radio_result, true);
        if (!empty($radio_data)) {
            if (!$radio_data['url']) {
                if (!$self) {
                    $radio_songs      = [
                        'error' => $radio_data['privilege'] ? '源站反馈此音频需要付费' : '找不到可用的播放地址',
                        'code' => 403
                    ];
                    return $radio_songs;
                }
                return false;
            }
            $radio_song_id    = $radio_data['hash'];
            $radio_song_album = str_replace('{size}', '150', $radio_data['album_img']);
            $radio_song_img   = str_replace('{size}', '150', $radio_data['imgUrl']);
            $radio_lrc    = self::getLyric($radio_song_id);
            $radio_songs    = [
                'type'   => 'kugou',
                'link'   => 'http://www.kugou.com/song/#hash=' . $radio_song_id,
                'songid' => $radio_song_id,
                'title'  => $radio_data['songName'],
                'author' => $radio_data['singerName'],
                'lrc'    => $radio_lrc,
                'url'    => $radio_data['url'],
                'pic'    => $radio_song_album ?: $radio_song_img
            ];
            return $self ? $radio_songs : [$radio_songs];
        }else{
            return;
        }
    }

    private static function getLyric($songid)
    {
        $radio_lrc_url = [
            'method'        => 'GET',
            'url'           => 'http://m.kugou.com/app/i/krc.php',
            'referer'       => 'http://m.kugou.com/play/info/' . $songid,
            'proxy'         => false,
            'body'          => [
                'cmd'        => 100,
                'timelength' => 999999,
                'hash'       => $songid
            ],
            'user-agent'    => 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X] AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1'
        ];
        return mc_curl($radio_lrc_url);
    }
}