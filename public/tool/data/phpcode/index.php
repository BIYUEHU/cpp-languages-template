<?php
include("ini.php");
?>
<html lang="zh-cn">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="format-detection" content="telephone=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
    <title>PHP加密 - HULI</title>
    <meta name="Keywords" content="<?php echo $ini['keywords'] ?>" />
    <meta name="Description" content="<?php echo $ini['description'] ?>" />
    <link href="//cdn.bootcss.com/bootstrap/3.2.0/css/bootstrap.css" rel="stylesheet">
    <script src="//cdn.bootcss.com/jquery/1.11.1/jquery.min.js"></script>
    <script src="//cdn.bootcss.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    <style>
        body {
            margin: 0 auto;
            text-align: center;
            background-image: url(bg.png);
            background-attachment: fixed;
            background-repeat: no-repeat;
            background-size: cover;
        }

        .container {
            max-width: 580px;
            padding: 15px;
            margin: 0 auto;
        }
    </style>
</head>

<body class="container">
    <div class="header">
        <ul class="nav nav-pills pull-right" role="tablist">
            <li role="presentation" class="active"><a href="/">首页</a></li>
        </ul>
        <h3 class="text-muted" align="left">PHP在线加解密</h3>
    </div>
    <hr>
    <div class="panel panel-primary" style="margin:1% 1% 1% 1%;background: rgba(255, 251, 251, 0.7)">
        <div class="panel-heading bk-bg-primary">
            <h6><span class="panel-title">PHP文件在线加密</span></h6>
        </div>
        <div class="panel-body">
            <label>输入你要处理的代码</label>
            <form method='post'>
                <div class="form-group">
                    <textarea class="form-control" rows="5" name="code"></textarea>
                </div>
                <select name="op" class="btn btn-primary btn-block bk-margin-top-10">
                    <option value="0" selected="selected">加密</option>
                    <option value="1">解密</option>
                </select>
                <input class="btn btn-primary btn-block bk-margin-top-10" type="submit" name="btn" value="点击处理">
            </form>

            <div class="form-group">
                <label>处理后的代码</label>
                <textarea class="form-control" rows="5"><?php
                                                        if (!empty($_POST['code'])) {
                                                            if ($_POST['op'] == 0) {
                                                                echo  htmlspecialchars(encode(stripcslashes($_POST['code'])));
                                                            } else if ($_POST['op'] == 1) {
                                                                echo  htmlspecialchars(decode(stripcslashes($_POST['code'])));
                                                            }
                                                        }
                                                        ?>
                    </textarea>
            </div>
            <?php
            if (!empty($_POST['encode']) != NULL && !empty($_POST['decode'])) {
                echo '<div class="alert alert-success" role="alert">
                        <span class="glyphicon glyphicon-info-sign"></span>
                        <strong>提示</strong>：处理成功！
                    </div>';
            }
            ?>
            <div class="alert alert-info" role="alert">
                <span class="glyphicon glyphicon-info-sign"></span>
                <strong>提示</strong>:输入要加密的PHP代码后点击按钮即可加密。
            </div>
            <div class="alert alert-warning" role="alert">
                <i class="glyphicon glyphicon-bullhorn"></i>
                <strong>公告</strong>:本站永久免费提供PHP文件加密服务。
            </div>
            <hr>
            <div class="container-fluid">
                <button type="button" class="btn btn-info btn-sm" data-toggle="collapse" data-target="#lxkf-1"><span class="glyphicon glyphicon-user"></span> 客服</button>
                <a href="http://wpa.qq.com/msgrd?v=3&uin=&site=qq&menu=yes" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-pencil"></span> 反馈</a>
            </div>
            <p style="text-align:center"><br>ByBiyuehu</p>
        </div>
    </div>
</body>

</html>