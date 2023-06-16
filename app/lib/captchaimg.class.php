<?php

class CaptchaImg
{
    public static $num = 4;
    public static $width = 100;
    public static $height = 30;
    
    public static function spawn() {
        session_start();

        $Code = '';
        for ($i = 0; $i < self::$num; $i++) {
            $Code .= mt_rand(0, 9);
        }

        // 将生成的验证码写入session
        $_SESSION['captchaimg_num'] = $Code;

        // 设置头部
        header("Content-type: image/png");

        // 创建图像（宽度,高度）
        $img = imagecreate(self::$width, self::$height);

        //创建颜色 （创建的图像，R，G，B）
        $GrayColor = imagecolorallocate($img, 230, 230, 230);
        $BlackColor = imagecolorallocate($img, 0, 0, 0);
        $BrColor = imagecolorallocate($img, 52, 52, 52);

        //填充背景（创建的图像，图像的坐标x，图像的坐标y，颜色值）
        imagefill($img, 0, 0, $GrayColor);

        //设置边框
        imagerectangle($img, 0, 0, self::$width - 1, self::$height - 1, $BrColor);

        //随机绘制两条虚线 五个黑色，五个淡灰色
        $style = array($BlackColor, $BlackColor, $BlackColor, $BlackColor, $BlackColor, $GrayColor, $GrayColor, $GrayColor, $GrayColor, $GrayColor);
        imagesetstyle($img, $style);
        imageline($img, 0, mt_rand(0, self::$height), self::$width, mt_rand(0, self::$height), IMG_COLOR_STYLED);
        imageline($img, 0, mt_rand(0, self::$height), self::$width, mt_rand(0, self::$height), IMG_COLOR_STYLED);

        //随机生成干扰的点
        for ($i = 0; $i < 200; $i++) {
            $PointColor = imagecolorallocate($img, mt_rand(0, 255), mt_rand(0, 255), mt_rand(0, 255));
            imagesetpixel($img, mt_rand(0, self::$width), mt_rand(0, self::$height), $PointColor);
        }

        //将验证码随机显示
        for ($i = 0; $i < self::$num; $i++) {
            $x = ($i * self::$width / self::$num) + mt_rand(5, 12);
            $y = mt_rand(5, 10);
            imagestring($img, 7, $x, $y, substr($Code, $i, 1), $BlackColor);
        }

        //输出图像
        imagepng($img);
        //结束图像
        imagedestroy($img);
    }
}

