<?php
$title = '插件设置';
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
        <div class="col-md-6">
            <form id="admin-email">
                <div class="tile">
                    <div class="tile-body">
                        <label class="control-label"><strong>SMTP邮件配置</strong></label>
                        <div class="form-group">
                            <label class="control-label">SMTP地址</label>
                            <input class="form-control" id="sets" setval="host" type="text" value="<?php echo $DATA['email']['host']; ?>" placeholder="smtp.qq.com" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label class="control-label">SMTP端口</label>
                            <input class="form-control" id="sets" setval="port" type="text" value="<?php echo $DATA['email']['port']; ?>" placeholder="465" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label class="control-label">账号</label>
                            <input class="form-control" id="sets" setval="username" type="text" value="<?php echo $DATA['email']['username']; ?>" placeholder="xxx@qq.com" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label class="control-label">密钥</label>
                            <input class="form-control" id="sets" setval="password" type="text" value="<?php echo $DATA['email']['password']; ?>" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label class="control-label">发件人邮箱</label>
                            <input class="form-control" id="sets" setval="fromuser" type="text" value="<?php echo $DATA['email']['fromuser']; ?>" placeholder="与账号一致" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label class="control-label">发件人名字</label>
                            <input class="form-control" id="sets" setval="fromname" type="text" value="<?php echo $DATA['email']['fromname']; ?>" placeholder="xxxx接口网站" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label class="control-label"><span style="color:#e60c0c">请确保已经开启了邮箱通讯服务</span></label>
                        </div>
                    </div>
                    <div class="tile-footer">
                        <button class="btn btn-primary" type="button" onclick="plugins_exec()">保存</button>
                        <button class="btn btn-primary" type="button" onclick="pluginssendemail()">发送测试邮件</button>
                    </div>
                </div>
            </form>
        </div>

        <div style="position: absolute;top: -9999px;left: -9999px">
            <form id="pluginssendemaillayer" class="layui-form" style="margin-top: 20px;width:95%">
                <div class="layui-form-item">
                    <label class="layui-form-label">收件人</label>
                    <div class="layui-input-block">
                        <input autocomplete="off" type="text" id="reveuser" required lay-verify="required" class="layui-input" />
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">标题</label>
                    <div class="layui-input-block">
                        <input autocomplete="off" type="text" id="title" required lay-verify="required" class="layui-input" />
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">正文</label>
                    <div class="layui-input-block">
                        <input autocomplete="off" type="text" id="message" required lay-verify="required" class="layui-input" />
                    </div>
                </div>
                <div class="layui-form-item">
                    <div class="layui-input-block">
                        <button class="layui-btn layui-btn-normal" lay-submit id="sendemail">确定</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <?php
    include(__DIR__ . '.../../user/footer.php');
    ?>

    </body>

    </html>