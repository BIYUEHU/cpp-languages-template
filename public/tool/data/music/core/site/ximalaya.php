<?php
// 喜马拉雅FM

namespace site;

class ximalaya
{
    
    public static function search($query, $page)
    {
        if (empty($query)) {
            return;
        }
        $radio_search_url = [
            'method'         => 'GET',
            'url'            => 'http://www.ximalaya.com/revision/search/main?',
            'referer'        => 'http://www.ximalaya.com',
            'proxy'          => false,
            'body'           => [
                'kw'         => $query,
                'core'       => 'track',
                'page'       => $page,
                'rows'       => 10,
                'condition'  => 'relation',
                'device'     => 'iPhone',
                'paidFilter' => 'true'
            ]
        ];
        $radio_result = mc_curl($radio_search_url);
        if (empty($radio_result)) {
            return;
        }
        $radio_songs = [];
        $radio_data = json_decode($radio_result, true);
        if (empty($radio_data['data']['track']) || empty($radio_data['data']['track']['docs'])) {
            return;
        }
        foreach ($radio_data['data']['track']['docs'] as $val) {
            if (!$val['is_paid']) { // 过滤付费的
                $radio_song = self::getSong($val['id'], true);
                if(is_array($radio_song)) $radio_songs[] = $radio_song;
            }
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
            'url'           => 'http://mobile.ximalaya.com/v1/track/ca/playpage/' . $songid,
            'referer'       => 'http://www.ximalaya.com',
            'proxy'         => false,
            'body'          => false
        ];
        $radio_result = mc_curl($radio_song_url);
        if (empty($radio_result)) {
            return;
        }
        $radio_json        = json_decode($radio_result, true);
        $radio_data        = $radio_json['trackInfo'];
        $radio_user        = $radio_json['userInfo'];
        if (!empty($radio_data) && !empty($radio_user)) {
            if ($radio_data['isPaid']) {
                $radio_songs = [
                    'error' => '源站反馈此音频需要付费',
                    'code' => 403
                ];
                return $radio_songs;
            }
            $radio_songs = [
                'type'   => 'ximalaya',
                'link'   => 'https://www.ximalaya.com/' . $radio_data['uid'] . '/sound/' . $radio_data['trackId'],
                'songid' => $radio_data['trackId'],
                'title'  => $radio_data['title'],
                'author' => $radio_user['nickname'],
                'lrc'    => '',
                'url'    => $radio_data['playUrl64'],
                'pic'    => $radio_data['coverLarge']
            ];
            return $self ? $radio_songs : [$radio_songs];
        }else{
            return;
        }
    }

}