<?php

$global_model = "text-davinci-003";
// $url = "https://api.openai.com/v1/engines/{$global_model}/completions";
$url = "https://api.openai.com/v1/chat/completions";

//设置请求参数
$data = array(
  'prompt' => 'Hello, how are you?',
  'max_tokens' => 50,
  'temperature' => 0.7,
);

//将请求参数编码为JSON格式
$data_json = json_encode($data);

//设置请求头部信息
$headers = array(
  'Content-Type: application/json',
  'Authorization: Bearer ' . $api_key,
);

//使用cURL发送请求
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

//获取API响应
$response = curl_exec($ch);

//处理API响应
if ($response === false) {
  echo 'Error: ' . curl_error($ch);
} else {
  $response_array = json_decode($response, true);
  echo $response_array['choices'][0]['text'];
}

//关闭cURL资源
curl_close($ch);