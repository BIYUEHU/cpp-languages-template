<?php

use MinecraftServerStatus\MinecraftServerStatus;

require(__DIR__ . '/src/MinecraftServerStatus.php');

header('Content-type: application/json');

function getLocation($ip = false)
{
	$ip = !$ip ? getRealIp() : $ip;
	$s = file_get_contents("http://whois.pconline.com.cn/ip.jsp?ip={$ip}", true);
	$encode = mb_detect_encoding($s, array("ASCII", 'UTF-8', "GB2312", "GBK", 'BIG5'));
	$s = mb_convert_encoding($s, 'UTF-8', $encode);
	$s = str_replace(PHP_EOL, '', $s);
	$s = str_replace("\r", '', $s);
	$s = str_replace("\n ", '', $s);
	$s = str_replace("\n", '', $s);
	return $s;
}

$ip = $_REQUEST['ip'];
$port = $_REQUEST['port'] ?? 25565;
$response = MinecraftServerStatus::query($ip, $port);

$code = 501;
$data = array("status" => "offline");
if ($response) {
    $code = 500;
    $data = array(
        "status" => "online",
        "ip" => $ip,
        "real" => $response['hostname'],
        "location" => getLocation($response['hostname']),
        "port" => $port,
        "motd" => $response['description_raw']->extra[0]->text,
        "agreement" => $response['protocol'],
        "version" => $response['version'],
        "online" => $response['players'],
        "max" => $response['max_players'],
        "ping" => $response['ping'],
        "icon" => $response['favicon'],
        "modinfo" => $response['modinfo']
    );
}

echo json_encode(array(
    "code" => $code,
    "message" => $code == 500 ? 'success' : 'error',
    "data" => $data
));
