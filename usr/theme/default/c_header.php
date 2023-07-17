<?php
/*
 * @Author: Biyuehu biyuehuya@gmail.com
 * @Blog: http://imlolicon.tk
 * @Date: 2023-01-15 16:23:32
 */
use Base\Controllers\Controller;
require_once(__DIR__ . "/function.php");

!isset($_GET['open']) || setcookie('open', 'ok', time() + 60 * 60 * 24);

$headUrlArr = explode('|', $THEME_SET['headUrl']);
$headUrl = '';
foreach ($headUrlArr as $val) {
    $val = explode(',', $val);
    $target = $val[2] == '1' ? 'target="_blank" ' : '';
    $headUrl = $headUrl . '<li class="nav-item"><a class="nav-link" ' . $target . 'href="' . $val[1] . '">' . $val[0] . '</a></li>';
}
empty($title) ? $subtitle = ' ' . $WEB_INFO['websubtitle'] : $title = $title . ' - ';

$DAT = [];
$DAT['numApi'] = Controller::numApiData();
$DAT['call'] = Controller::callData();
$DAT['visit'] = Controller::visitWebData();
$DAT['visitor'] = Controller::visitorWebData();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <meta name="description" content="<?php echo $WEB_INFO['webdescr']; ?>">
    <meta name="keywords" content="<?php echo $WEB_INFO['keywords']; ?>,<?php echo $WEB_INFO['webtitle']; ?>">
    <meta name="author" content="<?php echo $WEB_INFO['author']; ?>">
    <meta name="founder" content="<?php echo $WEB_INFO['webtitle']; ?>">
    <title>
        <?php echo $title . $WEB_INFO['webtitle'] . $subtitle; ?>
    </title>
    <link rel="shortcut icon" href="/favicon.ico">
    <style>
        :root {
            --set-main-color: <?php echo $THEME_SET['mainColor'] ?>;
            --set-accent-color: <?php echo $THEME_SET['accentColor'] ?>;
        }
    </style>
    <link rel="stylesheet" href="<? echo $CONFIG['path'] ?>/css/user/main.css">
    <link rel="stylesheet" href="<? echo $CONFIG['path'] ?>/css/site.min.css">
    <link rel="stylesheet" href="<? echo $CONFIG['path'] ?>/css/oneui.css">
    <link rel="stylesheet" href="<? echo $CONFIG['path'] ?>/css/index.css">
    <link rel="stylesheet" href="//cdn.staticfile.org/layui/2.8.7/css/layui.css">
    <link rel="stylesheet" href="//cdn.staticfile.org/highlight.js/11.8.0/styles/base16/dracula.min.css">
    <script src="<? echo $CONFIG['path'] ?>/js/index.js"></script>
    <script src="//cdn.staticfile.org/bootstrap/5.2.3/js/bootstrap.min.js"></script>
    <script src="//cdn.staticfile.org/highlight.js/11.8.0/highlight.min.js"></script>
    <script
        src="//cdn.staticfile.org/highlightjs-line-numbers.js/2.8.0/highlightjs-line-numbers.min.js"></script>
    <script src="//cdn.staticfile.org/layui/2.8.7/layui.js"></script>
    <script src="//cdn.staticfile.org/jquery/3.7.0/jquery.min.js"></script>
    <script>
        hljs.highlightAll();
        hljs.initLineNumbersOnLoad({
            singleLine: true
        });
    </script>
    <script type="text/javascript">
        const startTime = '<?php echo $WEB_INFO["createTime"]; ?>';
    </script>
    <?php echo $THEME_SET["codeHead"]; ?>
</head>

<body>
    <!--头部-->
    <header class="site-header">
        <nav style="background-color:var(--set-accent-color);text-align:left;" class="navbar navbar-expand-md navbar-expand-lg navbar-dark">
            <a class="navbar-brand mr-auto" href="/">
                <img src="/favicon.ico" width="30" height="30" />
                <?php echo $WEB_INFO['webtitle']; ?>
            </a>
            <button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarHeader" aria-controls="navbarHeader" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="navbar-collapse collapse" id="navbarHeader">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/">Home</a>
                    </li>
                    <?php echo $headUrl ?>
                </ul>
                <div class="form-inline mt-2 mt-md-0">
                    <a target="_blank" href="<?php echo APP_USER_PATH ?>/">
                    <?php if ($VERIFY['name']): ?>
                        <span>User:<strong><? echo $VERIFY['name']; ?></strong></span>
                        <img src="/sys/getaccountavatar" style="width:35px;height:35px;border-radius:50%;margin-bottom:3px;" />
                    <? else: ?>
                        <button class="btn btn-outline-info my-2 my-sm-0">Login</button>
                    <? endif; ?>
                    </a>
                </div>
            </div>
        </nav>
        <div class="content box-text">
            <h1 style="color:#00FFFF">
                <?php echo $WEB_INFO['webtitle']; ?>
            </h1>
            <h3>
                <?php echo $WEB_INFO['webdescr']; ?>
            </h3><br>
            <span style="font-size:16px">总计<strong>
                    <?php echo $DAT['numApi']['total']; ?>
                </strong> 个接口</h3><br>
                本站链接：
                <?php echo $WEB_INFO['weburl']; ?><img width="13" height="13" src="/images/ico.png" alt="正版认证">
                <br>
            </span>
            <span id=localtime></span>
            <script type="text/javascript">
            </script>
            <marquee scrollamount="5" onmouseover="this.stop()" onmouseout="this.start()">
                <?php echo $THEME_SET['openRoll']; ?>
            </marquee>
        </div>
    </header>


    <section class="content content-boxed">
        <p style="color:#FFCC00" class="p-jsxs">
            <?php echo $THEME_SET['tips']; ?>
        </p>

        <!--广告位-->
        <div>
            <?php if (!empty($THEME_SET['advert'])):
                $arr = explode('|', $THEME_SET['advert']);
                foreach ($arr as $val):
                    ?>
                    <a class="link" href="<? echo $val; ?>" target="_blank" rel="noopener noreferrer nofollow">
                        <img style="align:center;width:100%;max-width:700px;max-height:170px;" src="<? echo $val; ?>"
                            alt="<? echo $val; ?>" />
                    </a>
                <? endforeach; endif; ?>
        </div>
    </section>