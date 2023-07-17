<?php

use Base\Controllers\Controller;
use Lib\Stat;

$title = '仪表盘';
include(__DIR__ . '/header.php');
include(__DIR__ . '/nav.php');

$DAT = [];
$DAT['numApi'] = Controller::numApiData();
$DAT['call'] = Controller::callData();
$DAT['callAvg'] = Controller::callDataAvg($WEB_INFO['createTime']);
$DAT['visitWeb'] = Controller::visitWebData();
$DAT['visitorWeb'] = Controller::visitorWebData();
?>

<main class="app-content">
    <div class="app-title">
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href=""><?php echo $title; ?></a></li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-6 col-lg-3">
            <div class="widget-small primary coloured-icon"><i class="icon fa fa-users fa-3x"></i>
                <div class="info">
                    <h4>累计调用</h4>
                    <p><b><?php echo $DAT['call']['total']; ?>次</b></p>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="widget-small warning coloured-icon"><i class="icon fa ly iconjinrirenwu"></i>
                <div class="info">
                    <h4>总访问量</h4>
                    <p><b><?php echo $DAT['visitWeb']['total']; ?>次</b></p>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-<? echo $lg1 = ($CONFIG['type'] == 'HotaruCore' ? 2 : 3) ?>">
            <div class="widget-small info coloured-icon"><i class="icon fa ly iconjinri"></i>
                <div class="info">
                    <h4>总访客数</h4>
                    <p><b><?php echo $DAT['visitorWeb']['total']; ?>人</b></p>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-<? echo $lg1 ?>">
            <div class="widget-small danger coloured-icon"><i class="icon fa fa-star fa-3x"></i>
                <div class="info">
                    <h4>平台接口</h4>
                    <p><b><?php echo $DAT['numApi']['total'] + $DAT['numApi']['out']; ?>个</b></p>
                </div>
            </div>
        </div>
        <? if ($CONFIG['type'] == 'HotaruCore') : ?>
            <div class="col-md-6 col-lg-2">
                <div class="widget-small primary coloured-icon"><i class="icon fa fa-sitemap fa-3x"></i>
                    <div class="info">
                        <h4>子站数量</h4>
                        <p><b><?php echo $DAT['site']['num']; ?>个</b></p>
                    </div>
                </div>
            </div>
        <? endif; ?>
    </div>

    <div class="row" style="margin-bottom: 30px;">
        <? if ($CONFIG['type'] != 'HotaruCore') : ?>
            <div class="col-md-4 ptch-index-info">
                <div class="layui-card ptch-overflow-y" style="height: auto">
                    <div class="layui-card-header" style="color:#FFCC00">
                        主站公告
                        <i class="layui-icon layui-icon-tips" lay-offset="5"></i>
                    </div>
                    <div class="layui-card-body layui-text layadmin-text">
                        <div id="site_notice"></div>
                    </div>
                </div>
            </div>
        <? endif; ?>
        <div class="col-md-<? echo ($CONFIG['type'] == 'HotaruCore' ? 7 : 5) ?> ptch-index-info">
            <div class="layui-card ptch-overflow-y" style="height: auto">
                <div class="layui-card-header" style="color:darkblue">
                    使用须知
                    <i class="layui-icon layui-icon-tips" lay-offset="5"></i>
                </div>
                <div class="layui-card-body layui-text layadmin-text">
                    <p>欢迎使用HULICore核心系统,为半开源项目 由Biyuehu(糊理)制作 <a href="http://imlolicon.tk" target="_blank">博客-></a> 欢迎打赏</p>
                    <p>1.核心设置谨慎更改;网站设置可设置大部分网站信息与其他选项</p>
                    <p>2.接口添加<-前往此处;查看现有接口或更改或删除接口->接口列表</p>
                    <p>3.功能设置包括邮箱配置、网站主题、第三方功能,支持自行开发更多主题、第三方功能</p>
                    <p>4.账号资料以查看管理账号信息或更改信息、更改密码</p>
                    <p>5.网站安全包括网站日志等;可对接</p>
                </div>
            </div>
        </div>

        <div class="col-md-<? echo ($CONFIG['type'] == 'HotaruCore' ? 5 : 3) ?> ptch-index-info">
            <div class="layui-card">
                <div class="layui-card-header" style="color:purple">服务器信息</div>
                <div class="layui-card-body layui-text ptch-overflow-x">
                    <table class="layui-table">
                        <colgroup>
                            <col width="100">
                        </colgroup>
                        <tbody>
                            <tr>
                                <td>系统</td>
                                <td>
                                    <?php
                                    $os = explode(" ", php_uname());
                                    echo $os[0] . "(" . ('/' == DIRECTORY_SEPARATOR ? $os[2] : $os[1]) . ")";
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td>PHP版本</td>
                                <td>
                                    <?php echo PHP_VERSION ?>
                                </td>
                            </tr>
                            <tr>
                                <td>读写权限</td>
                                <td>
                                    <?php echo (is_readable(HULICORE_CONFIG_PATH . '/database.php') ? '<span style="color: green;">可读</span>' : '<span style="color: red;">不可读</span>') . ' ' . (is_writable(HULICORE_CONFIG_PATH . '/database.php') ? '<span style="color: green;">可写</span>' : '<span style="color: red;">不可写</span>') ?>
                                </td>
                            </tr>
                            <tr>
                                <td>解释引擎</td>
                                <td style="padding-bottom: 0;">
                                    <?php echo $_SERVER['SERVER_SOFTWARE']; ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Core版本</td>
                                <td style="padding-bottom: 0;">
                                    <?php echo HULICORE_INFO_VERSION; ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row" style="margin-bottom: 20px;">
        <div class="col-md-4 ptch-index-info">
            <div class="layui-card ptch-overflow-y">
                <div class="layui-card-header">
                    统计数据
                </div>
                <div class="layui-card-body layui-text layadmin-text">
                    <?php
                    echo "<p>每月调用次数:{$DAT['callAvg']['mouth']} 每周调用次数:{$DAT['callAvg']['week']}</p>
                    <p>每天调用次数:{$DAT['callAvg']['day']} 每时调用次数:{$DAT['callAvg']['hour']}</p>
                    <strong><p>今日调用次数:{$DAT['call']['today']} 昨日调用次数:{$DAT['call']['yesterday']} 调用次数趋势:<span style=\"color:" . ($DAT['call']['today'] > $DAT['call']['yesterday'] ? "#33FF00\">↑" : "#FF0033\">↓") . floor($DAT['call']['today'] - $DAT['call']['yesterday']) . "%</span>" . "</p></strong>";
                    ?>
                </div>
            </div>
        </div>

        <div class="col-md-4 ptch-index-info">
            <div class="layui-card ptch-overflow-y" style="height: auto">
                <div class="layui-card-header">
                    接口数据
                </div>
                <div class="layui-card-body layui-text layadmin-text">
                    <p>正常接口(可用):<?php echo $DAT['numApi']['well'] ?></p>
                    <p>维护接口(不可用):<?php echo $DAT['numApi']['bad'] ?></p>
                    <p>外链接口(仅收录):<?php echo $DAT['numApi']['out'] ?></p>
                    <p>隐藏接口:<?php echo $DAT['numApi']['hide'] ?></p>
                </div>
            </div>
        </div>

        <div class="col-md-4 ptch-index-info">
            <div class="layui-card ptch-overflow-y" style="height: auto">
                <div class="layui-card-header">
                    访问数据
                </div>
                <div class="layui-card-body layui-text layadmin-text">
                    <?php echo "<p>今日访问量:{$DAT['visitWeb']['today']} 昨日访问量:{$DAT['visitWeb']['yesterday']} 访问量趋势:<span style=\"color:" . ($DAT['visitWeb']['today'] > $DAT['visitWeb']['yesterday'] ? "#33FF00\">↑" : "#FF0033\">↓") . floor($DAT['visitWeb']['today'] - $DAT['visitWeb']['yesterday']) . "%</span>" . "</p>
                    <p>今日访客数:{$DAT['visitorWeb']['today']} 昨日访客数:{$DAT['visitorWeb']['yesterday']} 访客数趋势:<span style=\"color:" . ($DAT['visitorWeb']['today'] > $DAT['visitorWeb']['yesterday'] ? "#33FF00\">↑" : "#FF0033\">↓") . floor($DAT['visitorWeb']['today'] - $DAT['visitorWeb']['yesterday']) . "%</span>" . "</p>"; ?>
                </div>
            </div>
        </div>


    </div>

    <div class="row" style="margin-bottom: 30px;">
        <div class="col-md-6 ptch-index-info">
            <div class="layui-card ptch-overflow-y" style="height: auto">
                <div class="layui-card-header">
                    接口调用统计
                </div>
                <div id="maincall" style="height:400px;"></div>
            </div>
        </div>

        <div class="col-md-6 ptch-index-info">
            <div class="layui-card ptch-overflow-y" style="height: auto">
                <div class="layui-card-header">
                    访问量统计
                </div>
                <div id="mainvisitWeb" style="height:400px;"></div>
            </div>
        </div>
    </div>

    <?php
    include(__DIR__ . '.../../user/footer.php');
    ?>
    <? if ($CONFIG['type'] != 'HotaruCore') : ?>
        <script>
            const URL = 'http://api.imlolicon.tk';
            // const URL = 'http://localhost';
            $.get(`${URL}/site/info`, {
                website: `<? echo $_SERVER['HTTP_HOST']; ?>`
            }, data => {
                data && data.data && $('#site_notice').html(data.data.notice);
            });

            $.get(`${URL}/site/update`, {
                version: `<? echo HULICORE_INFO_VERSION; ?>`
            }, data => {
                if (data.code == 500) return;
                const layer = layui.layer;
                console.log(data);
                layer.open({
                    title: '更新提示',
                    content: `最新版本：${data.data.version}<br>当前版本：<?php echo HULICORE_INFO_VERSION ?><br>${data.data.descr}`,
                    yes: function(index, layero) {
                        $.get("/?open");
                        layer.close(index);
                    }
                });
            });
        </script>
    <? endif; ?>

    <script src="//cdn.staticfile.org/echarts/5.4.2/echarts.min.js"></script>
    <script>
        echartsRender1('maincall', ['7日前', '6日前', '5日前', '4日前', '3日前', '2日前', '昨日', '今日'], <?php echo '[' . Stat::QueryDayTag('api_call_' . Stat::StatName, 7) . ', ' . Stat::QueryDayTag('api_call_' . Stat::StatName, 6) . ', ' . Stat::QueryDayTag('api_call_' . Stat::StatName, 5) . ', ' . Stat::QueryDayTag('api_call_' . Stat::StatName, 4) . ', ' . Stat::QueryDayTag('api_call_' . Stat::StatName, 3) . ', ' . Stat::QueryDayTag('api_call_' . Stat::StatName, 2) . ', ' . $DAT['call']['yesterday'] . ', ' . $DAT['call']['today'] . ']'; ?>)
        echartsRender1('mainvisitWeb', ['7日前', '6日前', '5日前', '4日前', '3日前', '2日前', '昨日', '今日'], <?php echo '[' . Stat::QueryDayTag('web_visit_' . Stat::StatName, 7) . ', ' . Stat::QueryDayTag('web_visit_' . Stat::StatName, 6) . ', ' . Stat::QueryDayTag('web_visit_' . Stat::StatName, 5) . ', ' . Stat::QueryDayTag('web_visit_' . Stat::StatName, 4) . ', ' . Stat::QueryDayTag('web_visit_' . Stat::StatName, 3) . ', ' . Stat::QueryDayTag('web_visit_' . Stat::StatName, 2) . ', ' . $DAT['visitWeb']['yesterday'] . ', ' . $DAT['visitWeb']['today'] . ']'; ?>)
    </script>
    </body>

    </html>