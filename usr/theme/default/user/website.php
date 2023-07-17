<?php
$title = '站点接入';
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
                <li class="breadcrumb-item">站点搭建与接入教程：<mark><a href="/article/website" target="_blank">点击查看</a></mark></li><br>
                <form id="person">
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label">请输入你的API接口站点的域名(一个账号仅支持一个站点)</label>
                            <input class="form-control" id="website" value="<? echo $VERIFY['website']?>"/>
                        </div>
                    </div>
                    <div class="tile-footer">
                        <button type="button" class="btn btn-primary" onclick="website_set()">保存</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php include(__DIR__ . '/footer.php'); ?>
    </body>

    </html>