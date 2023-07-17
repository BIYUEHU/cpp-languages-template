<?php
$title = '文章';
include(__DIR__ . '/header.php');
?>
<style>
    html {
        color-scheme: light dark;
    }

    /* body {
        font-family: system-ui;
        font-size: 1.125rem;
        line-height: 1.5;
    }
    .main {
        width: min(70ch, 100% - 4rem);
        margin-inline: auto;
    }
    */

    .main-top-Brief img, svg, video {
        max-width: 100%;
        display: block;
    }

</style>

<link rel="stylesheet" href="<? echo $CONFIG['path'] ?>/css/friends.css">
<section>
    <div class="centent">
        <div class="mian">
            <div class="main-top">
                <div class="main-top-title">
                    <h2>文章</h2>
                    <h2>
                </div>
                <div class="main-top-Brief">
                <?php include($DATA); ?>
                <br>
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