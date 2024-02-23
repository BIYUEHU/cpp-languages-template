<?php
$customStr = '<p class="app-sidebar__user-name" id="goodMsg"></p>';

$navList = [
    ['./', '仪表盘', 'fa-dashboard'],
    ['./webset', '网站设置', 'fa-gear'],
    ['./apiadd', '接口添加', 'fa-plus'],
    ['./apilist', '接口列表', 'fa-map'],
    ['./fileupload', '文件上传', 'fa-code'],
    ['./account', '用户列表', 'fa-user'],
    ['./websafe', '网站安全', 'fa-fire'],
    ['./themes', '主题设置', 'fa-paint-brush'],
    ['./plugins', '插件设置', 'fa-asterisk'],
    [APP_USER_PATH . '/', '返回前台', 'fa-home'],
];
$TYPE && array_push($navList, ['./other', '扩展设置', 'fa-gears']);

include(__DIR__ . '../../user/nav.php');
