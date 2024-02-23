<?php
// 一听音乐

namespace site;

class m1ting
{
    
    public static function search($query, $page)
    {
        if (empty($query)) {
            return;
        }
        $radio_search_url = [
            'method'         => 'GET',
            'url'            => 'https://so.1ting.com/song/json',
            'referer'        => 'https://h5.1ting.com/',
            'proxy'          => false,
            'body'           => [
                'q'          => $query,
                'page'       => $page,
                'size'       => 10
            ]
        ];
        $radio_result = mc_curl($radio_search_url);
        if (empty($radio_result)) {
            return;
        }
        $radio_data = json_decode($radio_result, true);
        if (empty($radio_data['results'])) {
            return;
        }
        foreach ($radio_data['results'] as $value) {
            $radio_song_id       = $value['song_id'];
            $radio_lrc  = self::getLyric($radio_song_id);
            $radio_songs[]      = [
                'type'   => '1ting',
                'link'   => 'https://www.1ting.com/player/6c/player_' . $radio_song_id . '.html',
                'songid' => $radio_song_id,
                'title'  => $value['song_name'],
                'author' => $value['singer_name'],
                'lrc'    => $radio_lrc,
                'url'    => 'https://h5.1ting.com/file?url=' . str_replace('.wma', '.mp3', $value['song_filepath']),
                'pic'    => 'https://' . $value['album_cover']
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
            'method'        => 'GET',
            'url'           => 'https://h5.1ting.com/touch/api/song',
            'referer'       => 'https://h5.1ting.com/#/song/' . $songid,
            'proxy'         => false,
            'body'          => [
                'ids'       => $songid
            ]
        ];
        $radio_result = mc_curl($radio_song_url);
        if (empty($radio_result)) {
            return;
        }
        $radio_songs = [];
        $radio_data             = json_decode($radio_result, true);
        if (!empty($radio_data)) {
            foreach ($radio_data as $value) {
                $radio_song_id  = $value['song_id'];
                $radio_lrc  = self::getLyric($radio_song_id);
                $radio_songs[]  = [
                    'type'   => '1ting',
                    'link'   => 'https://www.1ting.com/player/6c/player_' . $radio_song_id . '.html',
                    'songid' => $radio_song_id,
                    'title'  => $value['song_name'],
                    'author' => $value['singer_name'],
                    'lrc'    => $radio_lrc,
                    'url'    => 'https://h5.1ting.com/file?url=' . str_replace('.wma', '.mp3', $value['song_filepath']),
                    'pic'    => 'http://img.store.sogou.com/net/a/link?&appid=100520102&w=500&h=500&url=' . $value['album_cover']
                ];
            }
            return $radio_songs;
        }else{
            return;
        }
    }

    private static function getLyric($songid)
    {
        $radio_lrc_url = [
            'method'        => 'GET',
            'url'           => 'https://www.1ting.com/api/geci/lrc/' . $songid,
            'referer'       => 'https://www.1ting.com/geci' . $songid . '.html',
            'proxy'         => false,
            'body'          => false
        ];
        return mc_curl($radio_lrc_url);
    }
}