<?php
$customStr = $customStr ?? "<p class=\"app-sidebar__user-name\">$rootTitle</p>";
if (empty($navList)) {
    $navList = [
        ['./', '面板台', 'fa-signal'],
        ['./apilist', '接口列表', 'fa-key'],
        ['./apishop', '接口商店', 'fa-shopping-bag'],
        ['./coinpay', '金额充值', 'fa-bank'],
        ['../', '访问主页', 'fa-home', 1]
    ];
    $TYPE && array_push($navList, ['./website', '站点接入', 'fa-sitemap']);
}
?>

<div class="app-sidebar__overlay" data-toggle="sidebar">
</div>
<aside class="app-sidebar">
    <div class="app-sidebar__user">
        <img class="app-sidebar__user-avatar" width="30%" src="/favicon.ico" alt="User Image">
        <div>
            <?php echo $customStr; ?>
            <p class="app-sidebar__user-designation"><?php echo date('Y-m-d H:i'); ?></p>
        </div>
    </div>
    <ul class="app-menu">
        <?php foreach ($navList as $val) : ?>
            <li>
                <a class="app-menu__item" href="<? echo $val[0]; ?>" <? echo $val[3] == 1 ? 'target="_blank"' : null; ?>>
                    <i class="app-menu__icon fa <? echo $val[2]; ?>"></i>
                    <span class="app-menu__label"><? echo $val[1]; ?></span>
                </a>
            </li>
        <? endforeach; ?>
    </ul>
</aside>