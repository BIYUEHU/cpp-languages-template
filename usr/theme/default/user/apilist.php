<?php
$title = '接口列表';
include(__DIR__ . '/header.php');
include(__DIR__ . '/nav.php');
?>

<main class="app-content">
    <div class="app-title">
        <ul class="app-breadcrumb breadcrumb side">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href=""><?php echo $title; ?></a></li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="bs-component">
                    <div class="alert alert-dismissible alert-success">
                        <input class="close" style="background-color:transparent;border:0;" type="button" value="x" data-dismiss="alert">
                        使用接口时传入<span style="color:red">【apikey】</span>参数与您的Apikey可单独统计调用次数
                    </div>
                </div>
                <div class="tile-body">
                    <table id="demo" lay-filter="nowline"></table>
                </div>
            </div>
        </div>
    </div>

    <?php
    include(__DIR__ . '/footer.php');
    ?>

    <script>
        apilist_user();
    </script>
    </body>

    </html>