<?php
// 5SING音乐

namespace site;

class m5sing
{
    
    public static function search($query, $page, $type)
    {
        if (empty($query)) {
            return;
        }
        $radio_search_url = [
            'method'         => 'GET',
            'url'            => 'http://goapi.5sing.kugou.com/search/search',
            'referer'        => 'http://5sing.kugou.com/',
            'proxy'          => false,
            'body'           => [
                'k'          => $query,
                't'          => '0',
                'filterType' => ($type=='yc'?'1':'2'),
                'ps'         => 10,
                'pn'         => $page
            ]
        ];
        $radio_result = mc_curl($radio_search_url);
        if (empty($radio_result)) {
            return;
        }
        $radio_songs = [];
        $radio_data = json_decode($radio_result, true);
        if (empty($radio_data['data']['songArray'])) {
            return;
        }
        foreach ($radio_data['data']['songArray'] as $val) {
            $radio_songs[] = self::getSong($val['songId'], $type, true);
        }
        return $radio_songs;
    }

    public static function getSong($songid, $type, $self = false)
    {
        if (empty($songid)) {
            return;
        }
        $radio_song_url = [
            'method'        => 'GET',
            'url'           => 'http://service.5sing.kugou.com/song/getsongurl',
            'referer'       => 'http://5sing.kugou.com/'.$type.'/' . $songid . '.html',
            'proxy'         => false,
            'body'          => [
                'songid'    => $songid,
                'songtype'  => $type
            ]
        ];
        $radio_result = mc_curl($radio_song_url);
        if (empty($radio_result)) {
            return;
        }
        $radio_json        = json_decode($radio_result, true);
        $radio_data        = $radio_json['data'];
        if (!empty($radio_data)) {
            $radio_song_id = $radio_data['songid'];
            $radio_songs = [
                'type'   => $type,
                'link'   => 'http://5sing.kugou.com/'.$radio_data['songtype'] . '/' . $radio_song_id . '.html',
                'songid' => $radio_song_id,
                'title'  => $radio_data['songName'],
                'author' => $radio_data['user']['NN'],
                'lrc'    => $radio_data['dynamicWords'],
                'url'    => $radio_data['lqurl'],
                'pic'    => $radio_data['user']['I']
            ];
            return $self ? $radio_songs : [$radio_songs];
        }else{
            return;
        }
    }

}