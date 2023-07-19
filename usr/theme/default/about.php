<?php
$title = '关于';
include(__DIR__ . '/header.php');
$file = $TYPE ? '/about.html' : '/c_about.html';
?>

<link rel="stylesheet" href="<? echo $CONFIG['path'] ?>/css/friends.css">
<section>
    <div class="centent">
        <div class="mian">
            <div class="main-top">
                <div class="main-top-title">
                    <h2>关于</h2>
                </div>
                <div class="main-top-Brief">
                <?php include(HULICORE_BASE_VIEW_PATH . $file); ?>
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