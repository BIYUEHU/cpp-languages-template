<?php
$title = '主题设置';
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
            <form id="webset" class="layui-form">
                <div class="tile">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>主题配色</label>
                                <input class="form-control" id="sets" setval="mainColor" type="text" value="<?php echo $THEME_SET['mainColor']; ?>" autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label>强调配色</label>
                                <input class="form-control" id="sets" setval="accentColor" type="text" value="<?php echo $THEME_SET['accentColor']; ?>" autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label>顶部项目</label>
                                <input class="form-control" id="sets" setval="headUrl" type="text" placeholder="名称,地址,是否新标签打开(0是/1否)|..." value="<?php echo $THEME_SET['headUrl']; ?>" autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label>顶部提示语</label>
                                <input class="form-control" id="sets" setval="tips" type="text" value="<?php echo $THEME_SET['tips'] ?>" autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label>弹窗公告</label>
                                <textarea class="form-control" id="sets" setval="openEjct" rows='4' autocomplete="off"><?php echo $THEME_SET['openEjct']; ?></textarea>
                            </div>
                            <div class="form-group">
                                <label>滚动公告</label>
                                <textarea class="form-control" id="sets" setval="openRoll" rows="2" autocomplete="off"><?php echo $THEME_SET['openRoll']; ?></textarea>
                            </div>
                            <div class="form-group">
                                <label>广告图片</label>
                                <input class="form-control " id="sets" setval="advert" type="text" placeholder="使用|间隔符分割多个图片URL" value="<?php echo $THEME_SET['advert']; ?>" autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label>底部信息1</label>
                                <textarea class="form-control" id="sets" setval="bottom1" rows='3' autocomplete="off"><?php echo $THEME_SET['bottom1']; ?></textarea>
                            </div>
                            <div class="form-group">
                                <label>底部信息2</label>
                                <textarea class="form-control" id="sets" setval="bottom2" rows='3' autocomplete="off"><?php echo $THEME_SET['bottom2']; ?></textarea>
                            </div>
                            <div class="form-group">
                                <label>自定义头部代码</label>
                                <textarea class="form-control" id="sets" setval="codeHead" rows='4' placeholder="将放置在head标签结束前" autocomplete="off"><?php echo $THEME_SET['codeHead']; ?></textarea>
                            </div>
                            <div class="form-group">
                                <label>自定义脚部代码</label>
                                <textarea class="form-control" id="sets" setval="codeFoot" rows='4' placeholder="将放置在body标签结束前" autocomplete="off"><?php echo $THEME_SET['codeFoot']; ?></textarea>
                            </div>
                            <div class="form-group">
                                <label>友情链接</label>
                                <textarea class="form-control" id="sets" setval="friends" rows='4' placeholder="地址,名称,介绍,图标|..." autocomplete="off"><?php echo $THEME_SET['friends']; ?></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="tile-footer">
                        <input value="webinfo" style="display: none">
                        <button type="button" class="btn btn-primary" onclick="themes()">保存</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <?php include(__DIR__ . '.../../user/footer.php'); ?>

    </body>

    </html>