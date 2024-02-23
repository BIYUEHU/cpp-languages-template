<?php
// 蜻蜓FM

namespace site;

class qingting
{
    
    public static function search($query, $page)
    {
        if (empty($query)) {
            return;
        }
        $radio_search_url = [
            'method'         => 'GET',
            'url'            => 'http://search.qingting.fm/v3/search',
            'referer'        => 'http://www.qingting.fm',
            'proxy'          => false,
            'body'           => [
                'categoryid' => 0,
                'k'          => $query,
                'page'       => $page,
                'pagesize'   => 10,
                'include'    => 'program_ondemand'
            ]
        ];
        $radio_result = mc_curl($radio_search_url);
        if (empty($radio_result)) {
            return;
        }
        $radio_songs = [];
        $radio_data = json_decode($radio_result, true);
        if (empty($radio_data['data']) || empty($radio_data['data']['data'])) {
            return;
        }
        foreach ($radio_data['data']['data']['docs'] as $value) {
            $radio_songs[]    = [
                'type'   => 'qingting',
                'link'   => 'http://www.qingting.fm/channels/' . $value['parent_id'] . '/programs/' . $value['id'],
                'songid' => $value['parent_id'] . '|' . $value['id'],
                'title'  => $value['title'],
                'author' => $value['parent_name'],
                'lrc'    => '',
                'url'    => 'http://od.qingting.fm/' . $value['file_path'],
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
            'url'           => 'http://i.qingting.fm/wapi/channels/' . self::split_songid($songid, 0) . '/programs/' . self::split_songid($songid, 1),
            'referer'       => 'http://www.qingting.fm',
            'proxy'         => false,
            'body'          => false
        ];
        $radio_result = mc_curl($radio_song_url);
        if (empty($radio_result)) {
            return;
        }
        $radio_json           = json_decode($radio_result, true);
        $radio_data           = $radio_json['data'];
        if (!empty($radio_data)) {
            $radio_channels   = [
                'method'  => 'GET',
                'url'     => 'http://i.qingting.fm/wapi/channels/' . $radio_data['channel_id'],
                'referer' => 'http://www.qingting.fm',
                'proxy'   => false,
                'body'    => false
            ];
            $radio_info       = json_decode(mc_curl($radio_channels), true);
            if (!empty($radio_info) && !empty($radio_info['data'])) {
                $radio_author = $radio_info['data']['name'];
                $radio_pic    = $radio_info['data']['img_url'];
            }
            $radio_songs    = [
                'type'   => 'qingting',
                'link'   => 'http://www.qingting.fm/channels/' . $radio_data['channel_id'] . '/programs/' . $radio_data['id'],
                'songid' => $radio_data['channel_id'] . '|' . $radio_data['id'],
                'title'  => $radio_data['name'],
                'author' => $radio_author,
                'lrc'    => '',
                'url'    => 'http://od.qingting.fm/' . $radio_data['file_path'],
                'pic'    => $radio_pic
            ];
            return $self ? $radio_songs : [$radio_songs];
        }else{
            return;
        }
    }

    // 分割 songid 并获取
    private static function split_songid($songid, $index = 0, $delimiter = '|') {
        if (mb_strpos($songid, $delimiter, 0, 'UTF-8') > 0) {
            $array = explode($delimiter, $songid);
            if (count($array) > 1) {
                return $array[$index];
            }
        }
        return;
    }

}