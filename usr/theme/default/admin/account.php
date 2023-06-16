<?php
$title = '账户管理';
include(__DIR__ . '/header.php');
include(__DIR__ . '/nav.php');
?>

<main class="app-content">    
    <div class="app-title">
        <ul class="app-breadcrumb breadcrumb side">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href=""><?php echo $title;?></a></li>
        </ul>
    </div>    
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <button type="button" class="btn btn-primary" onclick="accountadd_open()">添加</button>
                <div class="tile-body">
                    <table id="demo" lay-filter="nowline"></table>
                </div>
            </div>
        </div>
    </div>

    <?php
    include(__DIR__ . '.../../user/footer.php');
    ?>

    <script>
        account();
    </script>
    </body>

    </html>