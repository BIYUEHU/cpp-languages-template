<?php
$title = $DATA['title'] . ' 文档';
include(__DIR__ . '/header.php');

$requesturl = $WEB_INFO['weburl'] . APP_API_PATH . '/' . $DATA['idstr'];
$returntype = $DATA['returnType'];
$requesttype = $DATA['requestType'];
$requesttemp = $requesturl . $DATA['requestTemp'];
$apikey = $DATA['apikey'] ?? '请先购买接口后使用';
?>

<link rel="stylesheet" href="/index.php/assets/css/doc.css">
<div class="layui-container">
    <div class="layui-row">
        <fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
            <legend><?php echo $DATA['title']; ?>API</legend>
        </fieldset>
        <blockquote class="layui-elem-quote"><?php echo ($DATA['coin'] > 0 ? "<span style=\"color:red\">本接口为付费接口 请<strong><a target=\"_blank\" href=\"" . APP_USER_PATH . "/apishop\">购买</a></strong>后使用</span><br>" : null).
        ($DATA['apiCallTotal'] != 0 ? "当前接口累计调用{$DATA['apiCallTotal']}次 今日调用{$DATA['apiCallToday']}次" : "当前无数据") .
        "<br> {$DATA['subtitle']} <i>Time:{$DATA['reg_date']}</i>"; ?></blockquote>
    </div>
    <div class="layui-tab layui-tab-brief" lay-filter="docDemoTabBrief">
        <ul class="layui-tab-title" style="text-align: center!important;">
            <li class="layui-this">API文档</li>
            <li>状态码参照</li>
            <li>代码示例</li>
        </ul>
        <div class="layui-tab-content">
            <div class="layui-tab-item layui-show">
                <p class="simpleTable">
                    <span class="layui-badge layui-bg-black">接口地址：</span>
                    <span class="url" data-clipboard-text="<?php echo $requesturl; ?>"><?php echo $requesturl; ?></span>
                </p>
                <p class="simpleTable">
                    <span class="layui-badge layui-bg-green">返回类型：</span>
                    <span class="url" data-clipboard-text="<?php echo $returntype; ?>"><?php echo $returntype; ?></span>
                </p>
                <p class="simpleTable">
                    <span class="layui-badge">请求方式：</span>
                    <span class="url" data-clipboard-text="<?php echo $requesttype; ?>"><?php echo $requesttype; ?></span>
                </p>
                <p class="simpleTable">
                    <span class="layui-badge layui-bg-blue">请求示例：</span>
                    <span class="url" data-clipboard-text="<?php echo $requesttemp; ?>"><?php echo $requesttemp; ?></span>
                </p>
                <?php if ($VERIFY['name']): ?>
                <p class="simpleTable">
                    <span class="layui-badge layui-bg-orange">用户密钥：</span>
                    <span class="url" data-clipboard-text="<?php echo $apikey; ?>"><?php echo $apikey; ?></span>
                </p>
                <? elseif (!$VERIFY['name'] && $DATA['coin'] > 0): ?>
                <p class="simpleTable">
                    <span class="layui-badge layui-bg-orange">用户密钥：</span>
                    <span class="url" data-clipboard-text="请先登录并购买后使用">请先登录并购买后使用</span>
                </p>
                <? endif; ?>
                <p class="linep">请求参数说明：</p>
                <table class="layui-table" lay-size="sm">
                    <thead>
                        <tr>
                            <th>名称</th>
                            <th>必填</th>
                            <th>类型</th>
                            <th>说明</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php echo $DATA['requestParHtml']; ?>
                    </tbody>
                </table>
                <p class="linep">返回参数说明：</p>
                <table class="layui-table" lay-size="sm">
                    <thead>
                        <tr>
                            <th>名称</th>
                            <th>类型</th>
                            <th>说明</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php echo $DATA['returnParHtml']; ?>
                    </tbody>
                </table>
                <p class="linep">返回示例：</p>
                <pre class="layui-elem-quote"><?php echo $DATA['returnTemp']; ?></pre>
            </div>
            <div class="layui-tab-item">
                <p class="linep">状态码说明：</p>
                <table class="layui-table" lay-size="sm">
                    <thead>
                        <tr>
                            <th>名称</th>
                            <th>说明</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php echo $DATA['codeParHtml']; ?>
                    </tbody>
                </table>
            </div>
            <div class="layui-tab-item">
                <p class="linep">调用示例：</p>
                <pre class="layui-elem-quote"><?php
if ($returntype == 'application/json') {
    $url = $WEB_INFO['weburl'] . '/api' . '/' . $DATA['idstr'] . $DATA['requestTemp'];
    include(HULICORE_BASE_VIEW_PATH . '/codeTemp.html');
} else {
    echo $DATA['codeTemp'];
}
?></pre>
            </div>
        </div>
    </div>
</div>

<?php
include(__DIR__ . '/footer.php');
?>

    <script src="/index.php/assets/js/clipboard.min.js"></script>
    <script>
        layui.use(() => {
            layui.code();
        });
        const clipboard = new ClipboardJS('.url');
        clipboard.on('success', function (e) {
            layer.msg('复制成功');
        });
        clipboard.on('error', function (e) {
            layer.msg(`错误:${e}`);
        });
    </script>

</body>

</html>