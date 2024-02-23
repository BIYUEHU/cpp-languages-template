<?php
// 酷我音乐

namespace site;

class kuwo
{
    
    public static function search($query, $page)
    {
        if (empty($query)) {
            return;
        }
        $radio_search_url = [
            'method'         => 'GET',
            'url'            => 'http://search.kuwo.cn/r.s',
            'referer'        => 'http://player.kuwo.cn/webmusic/play',
            'proxy'          => false,
            'body'           => [
                'all'        => $query,
                'ft'         => 'music',
                'itemset'    => 'web_2013',
                'pn'         => $page - 1,
                'rn'         => 10,
                'rformat'    => 'json',
                'encoding'   => 'utf8'
            ]
        ];
        $radio_result = mc_curl($radio_search_url);
        if (empty($radio_result)) {
            return;
        }
        $radio_songs = [];
        $radio_result = str_replace('\'', '"', $radio_result);
        $radio_data   = json_decode($radio_result, true);
        if (empty($radio_data['abslist'])) {
            return;
        }
        foreach ($radio_data['abslist'] as $val) {
            $radio_song = self::getSong(str_replace('MUSIC_', '', $val['MUSICRID']), true);
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
            'url'           => 'http://m.kuwo.cn/newh5/singles/songinfoandlrc',
            'referer'       => 'http://www.kuwo.cn/play_detail/' . $songid,
            'proxy'         => false,
            'body'          => [
                'musicId' => $songid
            ],
            'user-agent'    => 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1'
        ];
        $radio_result = mc_curl($radio_song_url);
        if (empty($radio_result)) {
            return;
        }
        $radio_json = json_decode($radio_result, true);
        $radio_data = $radio_json['data'];
        if (!empty($radio_data)) {
            $radio_lrclist = $radio_data['lrclist'];
            $radio_lrc = $radio_lrclist ? self::generate_kuwo_lrc($radio_lrclist) : null;
            $songinfo = $radio_data['songinfo'];
            $radio_song_id = $songinfo['id'];
            $radio_format = $songinfo['coopFormats'][0];
            if(!$radio_format) $radio_format = '128kmp3';
            $radio_songs          = [
                'type'   => 'kuwo',
                'link'   => 'http://www.kuwo.cn/play_detail/' . $radio_song_id,
                'songid' => $radio_song_id,
                'title'  => $songinfo['songName'],
                'author' => $songinfo['artist'],
                'lrc'    => $radio_lrc,
                'url'    => self::getSongUrl($radio_song_id, $radio_format),
                'format' => $radio_format,
                'pic'    => $songinfo['pic']
            ];
            return $self ? $radio_songs : [$radio_songs];
        }else{
            return;
        }
    }

    private static function getSongUrl($songid, $radio_format){
        $radio_lrc_url = [
            'method'        => 'GET',
            'url'           => 'http://www.kuwo.cn/api/v1/www/music/playUrl',
            'referer'       => 'http://www.kuwo.cn/play_detail/' . $songid,
            'proxy'         => false,
            'body'          => [
                'mid' => $songid,
                'type' => 'music',
                'httpsStatus' => '1'
            ]
        ];
        $radio_result = mc_curl($radio_lrc_url);
        $arr = json_decode($radio_result, true);
        return $arr['data']['url'];
    }

    private static function getLyric($songid)
    {
        $radio_lrc_url = [
            'method'        => 'GET',
            'url'           => 'http://m.kuwo.cn/newh5/singles/songinfoandlrc',
            'referer'       => 'http://www.kuwo.cn/play_detail/' . $songid,
            'proxy'         => false,
            'body'          => [
                'musicId' => $songid
            ],
            'user-agent'    => 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1'
        ];
        $radio_result = mc_curl($radio_lrc_url);
        $arr = json_decode($radio_result, true);
        $radio_lrclist = $arr['data']['lrclist'];
        return $radio_lrclist ? self::generate_kuwo_lrc($radio_lrclist) : null;
    }

    // 生成酷我音乐歌词
    private static function generate_kuwo_lrc($lrclist) {
        if (!empty($lrclist)) {
            $lrc = '';
            foreach ($lrclist as $val) {
                if ($val['time'] > 60) {
                    $time_exp = explode('.', round($val['time'] / 60, 4));
                    $minute = $time_exp[0] < 10 ? '0' . $time_exp[0] : $time_exp[0];
                    $sec = substr($time_exp[1], 0, 2) . '.' . substr($time_exp[1], 2, 2);
                    $time = '[' . $minute . ':' . $sec . ']';
                } else {
                    $time = '[00:' . $val['time'] . ']';
                }
                $lrc .= $time . $val['lineLyric'] . "\n";
            }
            return $lrc;
        }
    }
}