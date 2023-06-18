<?php
$title = '金额充值';
include(__DIR__ . '/header.php');
include(__DIR__ . '/nav.php');
?>
<!-- 主体 -->
<main class="app-content">
    <div class="app-title">
        <ul class="app-breadcrumb breadcrumb side">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href=""><?php echo $title; ?></a></li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="bs-component">
                    <div class="alert alert-dismissible alert-success">
                        <input class="close" style="background-color:transparent;border:0;" type="button" value="x" data-dismiss="alert">
                        汇率: <span style="color:red">【1￥】</span>=50 Coins
                    </div>
                </div>
                <form class="layui-form layui-form-pane" id="user-order">
                    <h1 style="margin: 0px 0px 8px 0px;font-size:1rem"><?php echo $title; ?></h1>
                    <div class="form-group">
                        <label class="control-label">充值数量</label>
                        <input class="form-control" id="coins" type="text" autocomplete="off">
                    </div>
                    <div class="from-group">
                        <label class="control-label">支付方式</label><br>
                        <input type="radio" name="type" value="1" title="微信支付" checked>
                        <input type="radio" name="type" value="1" title="支付宝支付">
                        <input type="radio" name="type" value="3" title="QQ支付">
                    </div>
                    <div style="text-align: center;margin: auto;">
                        <button type="button" class="btn btn-primary btn-block" onclick="trypay()">立即支付</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php
    include(__DIR__ . '/footer.php');
    ?>

    </body>

    </html>