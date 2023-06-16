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
    <title><?php echo $title . ' - ' . $WEB_INFO['webtitle'] . ($rootTitle ?? '后台') ?></title>
    <link rel="shortcut icon" href="/favicon.ico">
    <style>
        :root {
            --set-main-color: <?php echo $THEME_SET['mainColor'] ?>;
            --set-accent-color: <?php echo $THEME_SET['accentColor'] ?>;
        }
    </style>
    <link rel="stylesheet" href="//unpkg.com/layui@2.6.8/dist/css/layui.css">
    <link rel="stylesheet" href="//cdn.staticfile.org/font-awesome/4.7.0/css/font-awesome.css">
    <link rel="stylesheet" href="/index.php/assets/css/user/font_1332398_z4m8t7izbwk.css">
    <link rel="stylesheet" href="/index.php/assets/css/index.css">
    <link rel="stylesheet" href="/index.php/assets/css/user/main.css">
</head>