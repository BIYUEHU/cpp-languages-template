<?php
/*
 * @Author: Biyuehu biyuehuya@gmail.com
 * @Blog: http://hotaru.icu
 * @Date: 2023-01-17 21:31:41
 */
header('Content-type: image/jpeg');
$type = intval($_GET['type']) == '1' ? 'CHINA' : 'DISK';
$res = file_get_contents('http://img.nsmc.org.cn/CLOUDIMAGE/FY4A/MTCC/FY4A_' . $type . '.JPG');
echo $res;
