<?php
/*
 * @Author: Hotaru biyuehuya@gmail.com
 * @Blog: http://hotaru.icu
 * @Date: 2023-01-17 13:36:45
 */

include(__DIR__ . '/head.php');
$rootTitle = $rootTitle ?? '用户中心';
$content = $content ?? spawnHtmlHeaderOption('./person', 'fa-user', '个人') .
    ($VERIFY['opgroup'] == 4 ? spawnHtmlHeaderOption(APP_ADMIN_PATH . '/', 'fa-dashboard', '后台') : null) .
    spawnHtmlHeaderOption('loginout', 'fa-sign-out', '退出');
?>

<body class="app sidebar-mini rtl">
    <header class="app-header"> <a class="app-header__logo" href="./"><? echo $CONFIG['type'] ?></a>
        <a class="app-sidebar__toggle" href="#" data-toggle="sidebar" aria-label="Hide Sidebar"></a>
        <ul class="app-nav">
            <li class="dropdown show"><a style="text-decoration: none;" class="app-nav__item" href="/" data-toggle="dropdown" aria-label="Open Profile Menu"><span><?php echo $VERIFY['name']; ?> <img src="/sys/getaccountavatar" style="width:30px;height:30px;border-radius:50%;margin-bottom:3px;" /> </span><i class="fa fa-user fa-lg"></i></a>
                <ul class="dropdown-menu settings-menu dropdown-menu-right">
                    <?php echo $content; ?>
            </li>
        </ul>
        </li>
        </ul>
    </header>