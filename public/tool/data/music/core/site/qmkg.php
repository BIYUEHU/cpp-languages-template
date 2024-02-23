<?php
// 全民K歌

namespace site;

class qmkg
{
    
    public static function search($query, $page)
    {
        if (empty($query)) {
            return;
        }
        $radio_search_url = [
            'method'         => 'GET',
            'url'            => 'https://kg.qq.com/cgi/kg_ugc_get_homepage',
            'referer'        => 'https://kg.qq.com',
            'proxy'          => false,
            'body'           => [
                'format'     => 'json',
                'type'       => 'get_ugc',
                'inCharset'  => 'utf8',
                'outCharset' => 'utf-8',
                'share_uid'  => $query,
                'start'      => $page,
                'num'        => 10
            ]
        ];
        $radio_result = mc_curl($radio_search_url);
        if (empty($radio_result)) {
            return;
        }
        $radio_songs = [];
        $radio_data = json_decode($radio_result, true);
        if (empty($radio_data['data']['ugclist'])) {
            return;
        }
        foreach ($radio_data['data']['ugclist'] as $val) {
            $radio_song = self::getSong($val['shareid'], true);
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
            'url'           => 'https://kg.qq.com/cgi/kg_ugc_getdetail',
            'referer'       => 'https://kg.qq.com',
            'proxy'         => false,
            'body'          => [
                'v'          => 4,
                'format'     => 'json',
                'inCharset'  => 'utf8',
                'outCharset' => 'utf-8',
                'shareid'    => $songid
            ]
        ];
        $radio_result = mc_curl($radio_song_url);
        if (empty($radio_result)) {
            return;
        }
        $radio_json        = json_decode($radio_result, true);
        $radio_data        = $radio_json['data'];
        if (!empty($radio_data)) {
            $radio_song_id      = is_array($songid) ? $songid[0] : $songid;
            $radio_lrc  = self::getLyric($radio_song_id);
            $radio_songs = [
                'type'   => 'kg',
                'link'   => 'https://kg.qq.com/node/play?s=' . $radio_song_id . '&shareuid='. $radio_data['uid'],
                'songid' => $radio_song_id,
                'title'  => $radio_data['song_name'],
                'author' => $radio_data['nick'],
                'lrc'    => $radio_lrc,
                'url'    => $radio_data['playurl'],
                'pic'    => $radio_data['cover']
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
            'url'           => 'https://kg.qq.com/cgi/fcg_lyric',
            'referer'       => 'https://kg.qq.com',
            'proxy'         => false,
            'body'          => [
                'format'     => 'json',
                'inCharset'  => 'utf8',
                'outCharset' => 'utf-8',
                'ksongmid'   => $songid
            ]
        ];
        $radio_result = mc_curl($radio_lrc_url);
        $arr = json_decode($radio_result, true);
        return isset($arr['data']['lyric']) ? $arr['data']['lyric'] : null;
    }
}