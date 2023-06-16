<?php
$title = '网站设置';
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
                                <label>网站URL</label>
                                <input class="form-control" id="sets" setval="weburl" type="text" value="<?php echo $WEB_INFO['weburl']; ?>" autocomplete="off">
                                <?php
                                $url = (((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'];
                                if ($WEB_INFO['weburl'] != $url) :
                                ?>
                                    <div class="alert alert-dismissible alert-success" style="color:red">
                                        <input class="close" style="background-color:transparent;border:0;" type="button" value="x" data-dismiss="alert">
                                        与当前站点URL不一致 <?php echo $url; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="form-group">
                                <label>网站标题</label>
                                <input class="form-control" id="sets" setval="webtitle" type="text" value="<?php echo $WEB_INFO['webtitle']; ?>" autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label>网站副标题</label>
                                <input class="form-control" id="sets" setval="websubtitle" type="text" value="<?php echo $WEB_INFO['websubtitle'] ?>" autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label>网站描述</label>
                                <input class="form-control" id="sets" setval="webdescr" type="text" value="<?php echo $WEB_INFO['webdescr']; ?>" autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label>网站关键字</label>
                                <input class="form-control" id="sets" setval="keywords" type="text" value="<?php echo $WEB_INFO['keywords']; ?>" autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label>联系邮箱</label>
                                <input class="form-control" id="sets" setval="email" type="text" value="<?php echo $WEB_INFO['email']; ?>" autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label>建站时间</label>
                                <input class="form-control createtime" id="sets" setval="createtime" type="text" value="<?php echo $WEB_INFO['createTime']; ?>" autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label>网站主题</label>
                                <select id="sets" setval="theme">
                                    <?php
                                    $themeCard = '';
                                    foreach ($DATA as $key => $value) {
                                        $selected = $value['header']['uuid'] == $THEME_INFO['header']['uuid'] ? ' selected' : '';
                                        echo '<option value="' . $key . '"' . $selected . '>' . $value['header']['name'] . '</option>';
                                        $themeCard = $themeCard . '<div class="layui-card ptch-overflow-y" style="height: auto;backgroud-color:blue;">
                                            <div class="layui-card-header"><strong>' . $value['header']['name'] . '</strong></div>
                                            <div class="layui-card-body layui-text layadmin-text">
                                                <li>' . $value['header']['descr'] . ' V' . $value['header']['version'] . '</li>
                                                <li>' . (empty($value['info']['author']) ? '' : 'By ' . $value['info']['author'])
                                            .  (empty($value['info']['license']) ? '' : ' ' . $value['info']['license'])
                                            . (empty($value['info']['url']) ? '' : ' <a target="_blank" href="' . $value['info']['url'] . '">' . $value['info']['url'] . '</a>') . '</li>
                                                ' . (empty($value['header']['icon']) ? '' : '<img style="width:60%;max-width:300px" src="/sys/getthemeicon?theme=' . $key . '">') . '    
                                            </div>
                                            <input value="webinfo" style="display: none">
                                        </div>';
                                        unset($selected);
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="tile-footer">
                        <input value="webinfo" style="display: none">
                        <button type="button" class="btn btn-primary" onclick="webset()">保存</button>
                    </div>
                    <br>
                    <div class="form-group">
                        <label><strong style="color:lightblue">主题列表</strong></label>
                        <?php echo $themeCard; ?>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <?php include(__DIR__ . '.../../user/footer.php'); ?>

    <script>
        webset_init();
    </script>

    </body>

    </html>