<?php
// 荔枝FM

namespace site;

class lizhi
{
    
    public static function search($query, $page)
    {
        if (empty($query)) {
            return;
        }
        $radio_search_url = [
            'method'         => 'GET',
            'url'            => 'https://m.lizhi.fm/vodapi/search/voice',
            'referer'        => 'https://m.lizhi.fm',
            'proxy'          => false,
            'body'           => [
                'deviceId'    => 'h5-b6ef91a9-3dbb-c716-1fdd-43ba08851150',
                'keywords'       => $query,
                'page'        => $page
            ],
            'user-agent'     => 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1'
        ];
        $radio_result = mc_curl($radio_search_url);
        if (empty($radio_result)) {
            return;
        }
        $radio_data = json_decode($radio_result, true);
        if (empty($radio_data['data'])) {
            return;
        }
        $radio_songs = [];
        foreach ($radio_data['data'] as $value) {
            $radio_song_id       = $value['voiceInfo']['voiceId'];
            $radio_songs[] = [
                'type'   => 'lizhi',
                'link'   => 'https://www.lizhi.fm/' . $value['userInfo']['band'] . '/' . $radio_song_id,
                'songid' => $radio_song_id,
                'title'  => $value['voiceInfo']['name'],
                'author' => $value['userInfo']['name'],
                'lrc'    => '',
                'url'    => $value['voicePlayProperty']['trackUrl'],
                'pic'    => $value['voiceInfo']['imageUrl']
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
            'url'           => 'https://m.lizhi.fm/vodapi/voice/info/' . $songid,
            'referer'       => 'https://m.lizhi.fm',
            'proxy'         => false,
            'body'          => false,
            'user-agent'    => 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1'
        ];
        $radio_result = mc_curl($radio_song_url);
        if (empty($radio_result)) {
            return;
        }
        $radio_data            = json_decode($radio_result, true);
        if (!empty($radio_data)) {
            $value = $radio_data['data']['userVoice'];
            $radio_song_id = $value['voiceInfo']['voiceId'];
            $radio_songs = [
                'type'   => 'lizhi',
                'link'   => 'https://www.lizhi.fm/' . $value['userInfo']['band'] . '/' . $radio_song_id,
                'songid' => $radio_song_id,
                'title'  => $value['voiceInfo']['name'],
                'author' => $value['userInfo']['name'],
                'lrc'    => '',
                'url'    => $value['voicePlayProperty']['trackUrl'],
                'pic'    => $value['voiceInfo']['imageUrl']
            ];
            return $self ? $radio_songs : [$radio_songs];
        }else{
            return;
        }
    }

}