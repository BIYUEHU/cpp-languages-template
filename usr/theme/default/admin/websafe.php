<?php
$title = '网站安全';
include(__DIR__ . '/header.php');
include(__DIR__ . '/nav.php');

?>

<main class="app-content">
    <div class="app-title">
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item">
                <i class="fa fa-home fa-lg"></i>
            </li>
            <li class="breadcrumb-item"><a href=""><?php echo $title;?></a></li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <form id="websafe" class="layui-form">
                <div class="tile">
                    <li class="breadcrumb-item">安全设置</li><br>
                    <div class="row">
                        <div class="col-lg-12">                            
                            <div class="form-group">
                                <label>全局接口跨域请求支持</label>
                                <br>
                                <input type="checkbox" id="sets" setval="crossdomain" lay-skin="switch" lay-text="ON|OFF" <?php echo ($WEB_SAFE['crossdomain'] == 'on' ? 'checked' : ''); ?>>
                            </div>
                            <div class="form-group">
                                <label>接口请求限制周期</label>
                                <input class="form-control" id="sets" setval="cycle" type="text" value="<?php echo $WEB_SAFE['cycle']; ?>" autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label>接口请求限制次数</label>
                                <input class="form-control" id="sets" setval="cyclenum" type="text" value="<?php echo $WEB_SAFE['cyclenum'] ?>" autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label>接口请求弹出提示</label>
                                <input class="form-control" id="sets" setval="refusemsg" type="text" value="<?php echo $WEB_SAFE['refusemsg']; ?>" autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label>维护接口弹出提示</label>
                                <input class="form-control" id="sets" setval="badapimsg" type="text" value="<?php echo $WEB_SAFE['badapimsg']; ?>" autocomplete="off">
                            </div>
<!--                             <div class="form-group">
                                <label>安全登录入口</label>
                                <input class="form-control" id="sets" setval="safeimport" type="text" value="<?php echo $WEB_SAFE['safeimport']; ?>" autocomplete="off">
                            </div> -->
                            <!-- 废弃 -->
                        </div>
                    </div>
                    <div class="tile-footer">
                        <input value="webinfo" style="display: none">
                        <button type="button" class="btn btn-primary" onclick="websafe()">保存</button>
                    </div>
                </div>
            </form>
        </div>
        
        <div class="col-md-12">
            <div class="tile">
                <li class="breadcrumb-item">安全日志</li>
                <div class="tile-body">
                    <table id="demo" lay-filter="nowline"></table>
                </div>
            </div>
        </div>
    </div>

    <?php include(__DIR__ . '.../../user/footer.php'); ?>

    <script>
        // websafe_init();
        websafelog();
    </script>

    </body>

    </html>