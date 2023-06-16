<?php
header('content-type:application/json');



//    CURL POST訪問
function send_post($remote_server, $post_string)
{
  $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $remote_server);
  curl_setopt($ch, CURLOPT_PROXY, $ip);
  curl_setopt($ch, CURLOPT_POSTFIELDS, 'mypost=' . $post_string);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/98.0.4758.80 Safari/537.36 Edg/98.0.1108.50");
  $data = curl_exec($ch);
  curl_close($ch);
  return $data;
}

//    獲取一個隨機7K賬號，不能低於6位且不能高於12位
function kid($len = 6)
{
  $t = time();    // 獲取當前時間戳
  $_md5 = md5($t);    // 將當前時間轉爲MD5
  $r = rand(0, 32 - $len);    // 獲取一個隨機數
  $_md5_12 = substr($_md5, $r, 12);    // 在加密的數據中隨機取出6-12位字符
  return $_md5_12;    // 返回結果
}

//    輸出JSON信息
function msg($msg, $code = 500)
{
  $ret = array(
    'code' => $code,
    'msg' => $msg
  );
  return json_encode($ret);
}


$name = $_REQUEST['name'];    // 獲取提交的姓名
$id = $_REQUEST['id'];    // 獲取提交的證件號
if ($name != '' &&  strlen($id) === 18) {    // 用戶提交的數據是否有效
  $kid = kid();    // 隨機獲取一個賬號
  $pwd = kid(8);    // 隨機獲取一個密碼
  $post_data = "authcode=72A3&identity=$kid&realname=$name&card=$id&mode=identity&codekey=reg&password=$pwd&reg_type=web7k";    // 提交數據
  $data = send_post('http://zc.7k7k.com/post_reg', $post_data);    // 獲取返回的數據
  $data = json_decode($data, true);    // 將JSON信息解析為數組

  if ($data['data'] == '实名信息认证失败14' || $data['data'] == '') {
    echo msg('error', 501);    // 證件號和姓名不匹配
  } elseif ($data['data'] == '已无实名认证次数，请于24小时后尝试16') {
    echo msg('Frequent access, please wait 24 hours and try again!', 502);    // 同一姓名和證件號查詢次數過多
  } else {
    echo msg('success');    // 證件號和姓名匹配
  }
} else {
  echo msg('Name or ID number is incorrect', 503);    // 姓名和證件號不符合規則
}
