<?php

use function Core\Func\loadConfig;

$TYPE = HULICORE_INFO_TYPE;
$CONFIG = loadConfig('theme.php');
$CONFIG['path'] = $TYPE ? '/index.php/assets' : $CONFIG['path'];
$CONFIG['type'] = $TYPE ? 'HotaruCore' : 'HULICore';

function spawnViewOpgroup($code)
{
    $data = [
        null,
        '<span style="color:black">封禁<span/>',
        '<span style="color:glay">待验证<span/>',
        '<span style="color:green">用户<span/>',
        '<span style="color:orange">管理<span/>'
    ];
    return $data[$code] ?? $data[1];
}


function spawnHtmlHeaderOption($href, $icon, $text)
{
    return "<li><a class=\"dropdown-item\" href=\"$href\"><i class=\"fa $icon fa-lg\"></i>$text</a></li>";
}
