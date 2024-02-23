<?php
error_reporting(0);
$user = $_GET['user'];

$url = 'http://tieba.baidu.com/home/get/panel?ie=utf-8&un=' . urlencode($user);
$data = get_curl($url);
$arr = json_decode($data, true);
//print_r($arr);exit;
if (array_key_exists('no', $arr) && $arr['no'] == 0) {
	$id = $arr['data']['id'];
	$sex = $arr['data']['sex'] == 'male' ? '男' : '女';
	$tb_age = $arr['data']['tb_age'];
	$post_num = $arr['data']['post_num'];
	$is_block = $arr['data']['is_block'];
	$is_private = $arr['data']['is_private'];
	if (!empty($arr['data']['vipInfo'])) {
		$isvip = 1;
		$v_status = $arr['data']['vipInfo']['v_status'] == 2 ? '贴吧超级会员' : '贴吧会员';
		$v_level = $arr['data']['vipInfo']['v_level'];
	} else {
		$isvip = 0;
	}
} else {
	exit('<div class="alert alert-warning">未找到"' . $user . '"用户的信息.</div>');
}

$url = 'http://koubei.baidu.com/home/' . $id;
$data = get_curl($url);
preg_match('!"regtime":(\d+),!', $data, $match);
$regtime = date("Y-m-d H:i:s", $match[1]);
preg_match('!"secureemail":"(.*?)",!', $data, $match);
$email = $match[1];
preg_match('!"securemobil":"(.*?)",!', $data, $match);
$mobile = $match[1];

//$result=array('id'=>$id,'user'=>$user,'sex'=>$sex,'tb_age'=>$tb_age,'post_num'=>$post_num,'is_block'=>$is_block,'is_private'=>$is_private,'isvip'=>$isvip,'v_status'=>$v_status,'v_level'=>$v_level,'regtime'=>$regtime,'email'=>$email,'mobile'=>$mobile);
$vip = $isvip == 1 ? $v_status . ' Lv' . $v_level : '非会员';
echo '<ul class="list-group">
<li class="list-group-item">用户：' . $user . '</li>
<li class="list-group-item">百度ID：' . $id . '</li>
<li class="list-group-item">性别：' . $sex . '</li>
<li class="list-group-item">吧龄：' . $tb_age . '</li>
<li class="list-group-item">发言数：' . $post_num . '</li>
<li class="list-group-item">是否VIP：' . $vip . '</li>
<li class="list-group-item">是否隐藏动态：' . ($is_private == 1 ? '是' : '否') . '</li>
<li class="list-group-item">是否被封禁：' . ($is_block == 1 ? '是' : '否') . '</li>
<li class="list-group-item">注册时间：' . $regtime . '</li>
<li class="list-group-item">绑定邮箱：' . $email . '</li>
<li class="list-group-item">绑定手机：' . $mobile . '</li>
</ul>';

function get_curl($url, $post = 0, $referer = 0, $cookie = 0, $header = 0, $ua = 0, $nobaody = 0)
{
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	$httpheader[] = "Accept:*/*";
	$httpheader[] = "Accept-Encoding:gzip,deflate,sdch";
	$httpheader[] = "Accept-Language:zh-CN,zh;q=0.8";
	$httpheader[] = "Connection:close";
	curl_setopt($ch, CURLOPT_HTTPHEADER, $httpheader);
	if ($post) {
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
	}
	if ($header) {
		curl_setopt($ch, CURLOPT_HEADER, true);
	}
	if ($cookie) {
		curl_setopt($ch, CURLOPT_COOKIE, $cookie);
	}
	if ($referer) {
		if ($referer == 1) {
			curl_setopt($ch, CURLOPT_REFERER, 'http://tieba.baidu.com/');
		} else {
			curl_setopt($ch, CURLOPT_REFERER, $referer);
		}
	}
	if ($ua) {
		curl_setopt($ch, CURLOPT_USERAGENT, $ua);
	} else {
		curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/45.0.2454.101 Safari/537.36");
	}
	if ($nobaody) {
		curl_setopt($ch, CURLOPT_NOBODY, 1);
	}
	curl_setopt($ch, CURLOPT_ENCODING, "gzip");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$ret = curl_exec($ch);
	curl_close($ch);
	return $ret;
}
