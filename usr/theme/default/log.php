<?php
$title = '更新日志';
include(__DIR__ . '/header.php');
?>

<style type="text/css">
    .logpaper {
        background: #ecedf0 url("/images/logpage.png") fixed;
        background-repeat: no-repeat;
        background-size: 100% 100%
    }
</style>

<section class="content content-boxed">
    <div><br></div>
    <div><br></div>
    <div><br></div>
    <div class='logpaper'>
        <h3 align="center"><iframe src="/res/updatelog.txt" style="width:100%;height:1000px;"></iframe></h3>
    </div>
    <div><br></div>
    <div><br></div>
    <div><br></div>
</section>

<?php
include(__DIR__ . '/footer.php');
?>

</body>

</html>