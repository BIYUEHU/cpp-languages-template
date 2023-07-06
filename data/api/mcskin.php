<?php
error_reporting(0);
// namespace Mcskin;

use function Core\Func\loadConfig;

class Mcskin
{
    private $playerName;
    private $playerUuid;
    private $skinData;
    private $skinUrl;
    private $capeUrl;
    private $avatar;
    public $result;
    private const API_UUID = "https://api.mojang.com/users/profiles/minecraft/";
    private const API_SKIN = "https://sessionserver.mojang.com/session/minecraft/profile/";
    private const TEMP_AVATAR = __DIR__ . '/temp/avatar.png';
    public function __construct($playerName)
    {
        $code = 501;
        if (!empty($playerName)) {
            $this->playerName = $playerName;
            $this->getPlayerUuid();
            $this->playerUuid && $this->getSkinData();
            $this->skinData && $this->handlerData();
            $this->skinData && $this->createAvatar();
            $code = $this->skinData ? 500 : 502;
        }
        $data = $this->skinUrl ? array(
            "skin" => $this->skinUrl,
            "cape" => $this->capeUrl ?? null,
            "avatar" => $this->avatar ?? null
        ) : null;
        $this->result = array(
            "code" => $code,
            "message" => loadConfig('apicode.php')[$code],
            "data" => $data
        );
    }

    private function getPlayerUuid()
    {
        $textData = file_get_contents(self::API_UUID . $this->playerName);
        $data = json_decode($textData, true);
        $this->playerUuid = $data['id'];
    }

    private function getSkinData()
    {
        $textData = file_get_contents(self::API_SKIN . $this->playerUuid);
        $data = json_decode($textData, true);
        $this->skinData = $data["properties"][0]["value"];
    }

    private function handlerData()
    {
        $textData = base64_decode($this->skinData);
        $data = json_decode($textData, true);
        $data = $data ? $data['textures'] : array();
        $this->skinUrl = $data['SKIN'] ? $data['SKIN']['url'] : null;
        $this->capeUrl = $data['CAPE'] ? $data['CAPE']['url'] : null;
    }

    private function createAvatar()
    {
        if (file_exists(self::TEMP_AVATAR)) {
            unlink(self::TEMP_AVATAR);
        }

        $size_avatar = 64;
        $copyskin = imagecreatetruecolor($size_avatar, $size_avatar);
        $originalskin = imagecreatefromstring(file_get_contents($this->skinUrl));
        imagecopyresized($copyskin, $originalskin, 0, 0, 8, 8, $size_avatar, $size_avatar, 8, 8);
        imagecopyresized($copyskin, $originalskin, 0, 0, 40, 8, $size_avatar, $size_avatar, 8, 8);
        imagepng($copyskin, self::TEMP_AVATAR);
        imagedestroy($copyskin);
        imagedestroy($originalskin);

        // 图片转base64
        $image_info = getimagesize(self::TEMP_AVATAR);
        $image_data = fread(fopen(self::TEMP_AVATAR, 'r'), filesize(self::TEMP_AVATAR));
        $this->avatar = 'data:' . $image_info['mime'] . ';base64,' . base64_encode($image_data);
    }
}

header('Content-type: application/json');
$playerName = $_REQUEST['name'];
$data = new Mcskin($playerName);
echo json_encode($data->result);
