<?php
$title = '文章';
include(__DIR__ . '/header.php');
?>

<link rel="stylesheet" href="/index.php/assets/css/friends.css">
<section>
    <div class="centent">
        <div class="mian">
            <div class="main-top">
                <div class="main-top-title">
                    <h2>文章</h2>
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