<?php
$qq = $_GET['qq'];
$group_id = $_GET['group_id'];
$nickname = $_GET['nickname'];
$title = $_GET['title'];
$sex = $_GET['sex'];
$level = $_GET['level'];
$cur_exp = $_GET['cur_exp'];
$total_exp = $_GET['total_exp'];
$msg_count = $_GET['msg_count'];
$sign = $_GET['sign'];
$font = __DIR__.'/font.ttf';

// 获取QQ头像    
$avatar = file_get_contents("https://q.qlogo.cn/g?b=qq&s=640&nk={$qq}"); 

// 创建图片    
$img = imagecreatetruecolor(1000, 500);

// 绘制背景色
$bgcolor = imagecolorallocate($img, 255, 255, 255);  
imagefilledrectangle($img, 0, 0, 1000, 500, $bgcolor);

// 绘制头像
$avatar_img = imagecreatefromstring($avatar); 
imagecopyresampled($img, $avatar_img, 0, 0, 0, 0, 500, 500, imagesx($avatar_img), imagesy($avatar_img));

// 文字颜色    
$sex_color = $sex == 'male' ? imagecolorallocate($img, 0, 0, 255) : imagecolorallocate($img, 255, 0, 255);

// 绘制文字
imagettftext($img, 30, 0, 550, 120, $sex_color, $font, "群: {$group_id}");
imagettftext($img, 23, 0, 550, 150, $color, $font, $nickname);

imagettftext($img, 21, 0, 540, 300, $color, $font, "🔎头衔:");
imagettftext($img, 21, 0, 740, 300, $color, $font, "🔔发言: {$msg_count}次");

imagettftext($img, 20, 0, 620, 300, $title_color, $font, $title);
imagettftext($img, 20, 0, 620, 350, $sign_color, $font, $sign ? "已签到" : "未签到");

imagettftext($img, 21, 0, 740, 350, $color, $font, "⚖️等级: LV.{$level}");
imagettftext($img, 18, 0, 865, 350, $color, $font, "({$cur_exp}/{$total_exp})");

// 绘制进度条  
function calculate_progress($cur_exp, $total_exp)
{
  $progress_arr = array();

  $base_num = 10;
  $progress = intval($cur_exp / $total_exp * 100);

  while ($progress >= $base_num) {
    $progress_arr[] = "🌑";
    $progress -= 10;
  }

  if ($progress > 0) {
    if ($progress < 5) {
      $progress_arr[] = "🌔";
    } else if ($progress == 5) {
      $progress_arr[] = "🌓";
    } else {
      $progress_arr[] = "🌒";
    }
  }

  while (count($progress_arr) < 10) {
    $progress_arr[] = "🌕";
  }

  return $progress_arr;
}

$progress_arr = calculate_progress($cur_exp, $total_exp);
$progress_y = 400;
for ($i = 0; $i < 10; $i++) {
  $moon_type = isset($progress_arr[$i]) ? $progress_arr[$i] : "🌕";
  imagettftext($img, 18, 0, 620, $progress_y, $color, $font, $moon_type);
  $progress_y += 20;
}

// 绘制性别符号  
$gender_color = $sex == 'male' ? imagecolorallocate($img, 0, 0, 255) : imagecolorallocate($img, 255, 0, 255);
$gender_code = $sex == 'male' ? '♂' : '♀';
imagettftext($img, 70, 0, 950, 50, $gender_color, $font, $gender_code);

// 输出图片  
header("Content-type: image/png");
imagepng($img);
imagedestroy($img);
