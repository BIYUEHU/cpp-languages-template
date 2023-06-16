<?php
$title = '个人资料';
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
        <div class="col-md-12">
            <div class="tile">
                <label><strong>名字: </strong><?php echo $VERIFY['name'] ?></label><br>
                <label><strong>邮箱: </strong><?php echo $VERIFY['email'] ?></label><br>
                <label><strong>权限: </strong><?php echo spawnViewOpgroup($VERIFY['opgroup']) ?></label><br>
                <label><strong>金额: </strong><?php echo $VERIFY['coin'] ?></label><br>
                <label><strong>注册时间: </strong><?php echo $VERIFY['reg_date'] ?></label><br>
                <label><strong>头像: </strong><img src="/sys/getaccountavatar" style="width:100px;height:100px;" /></label><br>
                <div class="layui-upload">
                    <button type="button" class="layui-btn" id="uploadavatar">上传图片</button>
                    <div style="width: 95px;">
                        <div class="layui-progress layui-progress-big" lay-showpercent="yes" lay-filter="demo">
                            <div class="layui-progress-bar" lay-percent=""></div>
                        </div>
                    </div>
                </div>
                <hr>
                <li class="breadcrumb-item">更改密码</li><br>
                <form id="person">
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label">旧密码</label>
                            <input class="form-control" id="password" autocomplete="off" type="password" placeholder="请输入旧密码">
                        </div>
                        <div class="form-group">
                            <label class="control-label">新密码</label>
                            <input class="form-control" id="passwordnew" autocomplete="off" type="password" placeholder="请输入新密码">
                        </div>
                        <div class="form-group">
                            <label class="control-label">确定新密码</label>
                            <input class="form-control" id="passwordnewago" autocomplete="off" type="password" placeholder="请再次输入新密码">
                        </div>
                    </div>
                    <div class="tile-footer">
                        <button type="button" class="btn btn-primary" onclick="person()">保存</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php include(__DIR__ . '/footer.php'); ?>
    <script>
        person_upload();
    </script>
    </body>

    </html>