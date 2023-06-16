<?php
$title = '面板台';
include(__DIR__ . '/header.php');
include(__DIR__ . '/nav.php');

?>

<main class="app-content">
    <div class="app-title">
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href=""><?php echo $title;?></a></li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-6 col-lg-3">
            <div class="widget-small danger coloured-icon"><i class="icon fa fa-signal fa-3x"></i>
                <div class="info">
                    <h4>累计调用</h4>
                    <p><b><?php echo $DATA['call']; ?>次</b></p>
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
        <!--         <div class="col-md-7 ptch-index-info">
            <div class="layui-card ptch-overflow-y" style="height: auto">
                <div class="layui-card-header" style="color:#FFCC00">
                    使用须知
                    <i class="layui-icon layui-icon-tips" lay-offset="5"></i>
                </div>
                <div class="layui-card-body layui-text layadmin-text">
                </div>
            </div>
        </div> -->

        <div class="col-md-7 ptch-index-info">
            <div class="layui-card">
                <div class="layui-card-header" style="color:chartreuse">
                    用户公告
                </div>
                <div class="layui-card-body layui-text layadmin-text">
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
                        <li class="layui-timeline-item">
                            <i class="layui-icon"></i>
                            <div class="layui-timeline-content layui-text">
                                <h3 class="layui-timeline-title">
                                    09月28日</h3>
                                <p>
                                    二维码生成 <br>
                                    快速将URL或者文字生成二维码 <i class="layui-icon"></i>
                                </p>
                            </div>
                        </li>
                        <li class="layui-timeline-item">
                            <i class="layui-icon"></i>
                            <div class="layui-timeline-content layui-text">
                                <h3 class="layui-timeline-title">
                                    07月15日</h3>
                                <p>
                                    ICP备案查询 <br>
                                    快速查询域名备案信息 <i class="layui-icon"></i>
                                </p>
                            </div>
                        </li>
                        <li class="layui-timeline-item">
                            <i class="layui-icon"></i>
                            <div class="layui-timeline-content layui-text">
                                <h3 class="layui-timeline-title">
                                    04月28日</h3>
                                <p>
                                    历史今日 <br>
                                    回顾历史的长河，历史是生活的一面镜子 <i class="layui-icon"></i>
                                </p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <?php
    include(__DIR__ . '/footer.php');
    ?>
    </body>

    </html>