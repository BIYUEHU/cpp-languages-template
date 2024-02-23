<?php
// 千千音乐

namespace site;

class baidu
{
    
    public static function search($query, $page)
    {
        if (empty($query)) {
            return;
        }
		$body = ['word'=>$query, 'timestamp'=>time(), 'appid'=>'16073360', 'type'=>'1'];
		$body['sign'] = self::createSign($body);
        $radio_search_url = [
            'method'         => 'GET',
            'url'            => 'https://music.taihe.com/v1/search',
            'referer'        => 'https://music.taihe.com/',
            'proxy'          => false,
            'body'           => $body
        ];
        $radio_result = mc_curl($radio_search_url);
        if (empty($radio_result)) {
            return;
        }
        $radio_songs = [];
        $radio_data = json_decode($radio_result, true);
        if (empty($radio_data['data']['typeTrack'])) {
            return;
        }
        foreach ($radio_data['data']['typeTrack'] as $val) {
			$radio_song = self::getSong($val['TSID'], true);
            if(is_array($radio_song)) $radio_songs[] = $radio_song;
        }
        return $radio_songs;
    }

    public static function getSong($songid, $self = false)
    {
        if (empty($songid)) {
            return;
        }
		$body = ['TSID'=>$songid, 'timestamp'=>time(), 'from'=>'web', 's_protocol'=>'1', 'appid'=>'16073360'];
		$body['sign'] = self::createSign($body);
        $radio_song_url = [
            'method'        => 'GET',
            'url'           => 'https://music.taihe.com/v1/song/tracklink',
            'referer'       => 'https://music.taihe.com/song/' . $songid,
            'proxy'         => false,
            'body'          => $body
        ];
        $radio_result = mc_curl($radio_song_url);
        if (empty($radio_result)) {
            return;
        }
        $radio_songs = [];
        $radio_json             = json_decode($radio_result, true);
        $radio_data             = $radio_json['data'];
        if ($radio_json['state']==true && !empty($radio_data)) {
			$radio_song_id  = $radio_data['TSID'];
			if ($radio_data['lyric']) {
				$radio_lrc  = mc_curl(['url'=>$radio_data['lyric']]);
			}
            $authors = [];
            if(isset($radio_data['artist'])){
                foreach($radio_data['artist'] as $author){
                    $authors[] = $author['name'];
                }
            }
			$radio_songs = [
				'type'   => 'baidu',
				'link'   => 'https://music.taihe.com/song/' . $radio_song_id,
				'songid' => $radio_song_id,
				'title'  => $radio_data['title'],
				'author' => implode(',', $authors),
				'lrc'    => $radio_lrc,
				'url'    => $radio_data['path'] ?? $radio_data['trail_audio_info']['path'],
				'pic'    => $radio_data['pic']
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
            'url'           => 'http://musicapi.qianqian.com/v1/restserver/ting',
            'referer'       => 'http://music.taihe.com/song/' . $songid,
            'proxy'         => false,
            'body'          => [
                'method' => 'baidu.ting.song.lry',
                'songid' => $songid,
                'format' => 'json'
            ]
        ];
        $radio_result = mc_curl($radio_lrc_url);
        $arr = json_decode($radio_result, true);
        return isset($arr['lrcContent']) ? $arr['lrcContent'] : null;
    }

	private static function createSign($param){
		$secret = '0b50b02fd0d73a9c4c8c3a781c30845f';
		ksort($param);
		$str = '';
		foreach ($param as $k => $v) {
			$str .= $k . "=" . $v . "&";
		}
		$str = substr($str, 0, -1);
		$sign = md5($str . $secret);
		return $sign;
	}
}