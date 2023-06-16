<?php

use Lib\Stat;

include(__DIR__ . '/header.php');
?>

<section class="content content-boxed">
    <div class="row row_jsxs" id="listApi">
        <?php
        // 还是foreach好使（汗
        foreach ($DATA as $value) {
            $title = $value['title'];
            $subtitle = $value['subtitle'];
            $idstr = $value['idstr'];
            $state = intval($value['state']);
            $url = 'iluh' . '/' . $idstr;
            $state != 2 ? $nums = Stat::QueryTag($idstr . '_' . Stat::StatName) : $nums = Stat::QueryTag($idstr);
            $nums == false ? $nums = 'No data' : null;
            $coin = $value['coin'];

            if ($state == 2) {
                echo '<div class="col-sm-4"><a target="_blank" class="block block-link-hover2 ribbon ribbon-modern ribbon-success" href="/jumpto?url=' . $value['returnTemp'] . '"><div class="ribbon-box font-w600">Calls:' . $nums . '</div><div class="block-content"><div class="h4 push-5"><i><strong>[HREF]</strong></i>' . $title . '</div><p class="text-muted">' . $subtitle . '</p></div></a></div>';
            } else if ($state == 1 && $coin > 0) {
                $back = $back . '<div class="col-sm-4"><a target="_blank" class="block block-link-hover2 ribbon ribbon-modern ribbon-warning" href="' . $url . '"><div class="ribbon-box font-w600">Calls:' . $nums . '</div><div class="block-content"><div class="h4 push-5">' . $title . '</div><p class="text-muted">' . $subtitle . '</p></div></a></div>';
            } else if ($state == 1 && $coin <= 0) {
                $back = $back . '<div class="col-sm-4"><a target="_blank" class="block block-link-hover2 ribbon ribbon-modern ribbon-success" href="' . $url . '"><div class="ribbon-box font-w600">Calls:' . $nums . '</div><div class="block-content"><div class="h4 push-5">' . $title . '</div><p class="text-muted">' . $subtitle . '</p></div></a></div>';
            } else if ($state == 0) {
                $back = $back . '<div class="col-sm-4"><a target="_blank" class="block block-link-hover2 ribbon ribbon-modern ribbon-danger" href="' . $url . '"><div class="ribbon-box font-w600">Bad</div><div class="block-content"><div class="h4 push-5">' . $title . '</div><p class="text-muted">' . $subtitle . '</p></div></a></div>';
            }
        }

        echo $back;
        ?>
    </div>
</section>


<?php
include(__DIR__ . '/footer.php');
?>

<?php if (!empty($THEME_SET['openEjct']) && !isset($_COOKIE['open'])) : ?>
    <script>
        const layer = layui.layer;
        layer.open({
            title: 'Open',
            content: '<?php echo $THEME_SET['openEjct'] ?>',
            yes: function(index, layero) {
                $.get("/?open");
                layer.close(index);
            }
        });
    </script>
<?php endif; ?>

</body>

</html>