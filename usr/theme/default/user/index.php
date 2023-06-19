<?php
$title = '面板台';
include(__DIR__ . '/header.php');
include(__DIR__ . '/nav.php');

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
            <div class="widget-small danger coloured-icon"><i class="icon fa fa-signal fa-3x"></i>
                <div class="info">
                    <h4>累计调用</h4>
                    <p><b><?php echo empty($DATA['call']) ? 0 : $DATA['call']; ?>次</b></p>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="widget-small info coloured-icon"><i class="icon fa fa-tasks fa-3x"></i>
                <div class="info">
                    <h4>拥有接口</h4>
                    <p><b><?php echo $DATA['numApi']; ?>个</b></p>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="widget-small primary coloured-icon"><i class="icon fa fa-btc fa-3x"></i>
                <div class="info">
                    <h4>账户余额</h4>
                    <p><b><?php echo $VERIFY['coin']; ?>元</b></p>
                </div>
            </div>
        </div>
    </div>

    <div class="row" style="margin-bottom: 30px;">
        <div class="col-md-7 ptch-index-info">
            <div class="layui-card">
                <div class="layui-card-header" style="color:chartreuse">
                    用户公告
                </div>
                <div class="layui-card-body layui-text layadmin-text">
                    <?php echo $WEB_INFO['useropen']; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="row" style="margin-bottom: 30px;">
        <div class="col-md-12">
            <div class="layui-card" style="overflow: scroll;max-height:520px;">
                <div class="layui-card-header set-accent-color">
                    更新日志
                    <i class="layui-icon layui-icon-tips" lay-offset="5"></i>
                </div>
                <div class="layui-card-body layui-text layadmin-text">
                    <ul class="layui-timeline">
                        <div id="content"></div>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <?php
    include(__DIR__ . '/footer.php');
    ?>
    <script src="//cdn.staticfile.org/marked/5.1.0/marked.min.js"></script>
    <script>
        let value = `<? echo $WEB_INFO['log']; ?>`;
        value = marked.parse(value);
        value = value.split('\n');
        $('#content').html(value);
    </script>
    </body>

    </html>