<section>
    <div class="col-sm-12">
        <div class="block block-link-hover2 ribbon ribbon-modern ribbon-success">
            <div class="block-content">
                <span id="runtime_span"></span>
                <p class="text-center">
                    <span id="showtime"></span>
                    <script type="text/javascript">
                        show_date_time();
                    </script>
                </p>
            </div>
        </div>
    </div>
    <footer id="footer" class="footer hidden-print">
        <div class="container">
            <div class="row">
                <div class="footer-links col-md-4 col-sm-12">
                    <strong>
                        <h3>关于</h3>
                    </strong>
                    <p><?php echo $THEME_SET['bottom1']; ?></p>
                    <p><a href="/about" target="_blank">更多</a></p>
                </div>
                <div class="footer-links col-md-4 col-sm-12">
                    <strong>
                        <h3>记录</h3>
                    </strong>
                    <ul class="list-unstyled list-inline">
                        <p>正常接口: <?php echo $DAT['numApi']['well']; ?><br>
                        总计调用次数: <?php echo $DAT['call']['total']; ?><br>
                        今日调用次数: <?php echo $DAT['call']['today']; ?><br>
                        今日访问数： <?php echo $DAT['visit']['today']; ?><br>
                        今日访客数: <?php echo $DAT['visitor']['today']; ?></p>
                        </ui>
                </div>
                <div class="footer-techs col-md-2 col-sm-12">
                    <h3>友链</h3>
                    <ul class="list-unstyled list-inline">
                        <?php
                        if (!empty($THEME_SET['friends'])) :
                            $friendsArr = explode('|', $THEME_SET['friends']);
                        ?>
                        <p>
                            <?php foreach ($friendsArr as $val) :
                                $val = explode(',', $val);
                            ?>
                            <a href="/jumpto?url=<? echo $val[0]; ?>" target="_blank"><? echo $val[1]; ?></a>
                            <? endforeach; ?>
                        </p>
                        <? endif; ?>
                    </ul>
                </div>
            </div>
        </div>
        <div class="copy-right">
            <?php echo APP_COPYRIGHT ?>
            本站使用<a href="http://github.com/biyuehu/hulicore">HULICORE</a>开源项目搭建
        </div>
    </footer>
</section>

<script type="text/javascript">
    clickEffect();
</script>
<?php echo $THEME_SET["codeFoot"]; ?>