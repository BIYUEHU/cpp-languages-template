<?php
$title = '友情链接';
include(__DIR__ . '/header.php');
?>

<link rel="stylesheet" href="<? echo $CONFIG['path'] ?>/css/friends.css">
<section>
    <div class="centent">
        <div class="mian">
            <div class="main-top">
                <div class="main-top-title">
                    <h2><?php echo $WEB_INFO['name']; ?>友情链接</h2>
                </div>
                <div class="main-top-Brief">
                    <p>如若想要添加友链请将标题与链接发送至邮箱<strong><?php echo $WEB_INFO['email']; ?></strong></p>
                    <p>链接：<?php echo $WEB_INFO['weburl']; ?></p>
                    <p>标题：<?php echo $WEB_INFO['webtitle']; ?></p>
                    <p>介绍：<?php echo $WEB_INFO['webdescr']; ?> 可选,不要太长</p>
                    <p>图标：<?php echo $WEB_INFO['weburl'] . '/favicon.ico'; ?>
                        可选,支持ico、png、jpg等</p>
                </div>
            </div>
            <div class="main-bot">
                <div class="main-bot-nr">
                    <?php
                    if (!empty($THEME_SET['friends'])) :
                        $friendsArr = explode('|', $THEME_SET['friends']);
                        foreach ($friendsArr as $val) :
                            $val = explode(',', $val);
                    ?>
                        <div>
                            <a target="_blank" href="<? echo $WEB_INFO['weburl']; ?>/jumpto?url=<? echo $val[0]; ?>" class="main-bot-nr-kp">
                                <div class="main-bot-nr-kp-k">
                                    <div class="main-bot-nr-kp-k-img">
                                        <img src="<? echo $val[3]; ?>" class="fff">
                                    </div>
                                    <div class="main-bot-nr-kp-k-n">
                                        <span class="p1"><? echo $val[1]; ?></span>
                                        <span class="p2"><? echo $val[2]; ?></span>
                                    </div>
                                </div>
                            </a>
                        </div>
                    <? endforeach;
                    endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>
<div><br></div>
<div><br></div>

<?php
include(__DIR__ . '/footer.php');
?>

</body>

</html>