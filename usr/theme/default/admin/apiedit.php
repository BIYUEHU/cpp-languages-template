<?php
$title = '接口编辑';
include(__DIR__ . '../../user/head.php');
?>

<main>
    <div class="col-md-12">
        <form id="apiedit" class="layui-form">
            <div class="tile">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label><strong>*标题</strong></label>
                            <input class="form-control" name="title" type="text" required placeholder="短网址生成" value="<?php echo $DATA['title']; ?>" autocomplete="off">
                        </div>

                        <div class="form-group">
                            <label><strong>*副标题</strong></label>
                            <input class="form-control" name="subtitle" type="text" required placeholder="将长网址进行缩短" value="<?php echo $DATA['subtitle']; ?>" autocomplete="off">
                        </div>

                        <div class="form-group">
                            <label>状态</label>
                            <select name="state">
                                <?php
                                echo '<option value="1"' . ($DATA['state'] == 1 ? ' selected' : null) . '>well正常</option>';
                                echo '<option value="0"' . ($DATA['state'] == 0 ? ' selected' : null) . '>bad维护</option>';
                                echo '<option value="2"' . ($DATA['state'] == 2 ? ' selected' : null) . '>out外链</option>';
                                echo '<option value="3"' . ($DATA['state'] == 3 ? ' selected' : null) . '>hide隐藏</option>';
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>返回示例</label>
                            <textarea class="form-control" name="returntemp" rows="5" placeholder='//填0表示本API为网页
{
    "code": 500,
    "msg": "success",
    "data": {
        "url": "http://imlolicon.tk"
    }
}' autocomplete="off"><?php echo $DATA['returnTemp']; ?></textarea>
                        </div>
                        <div class="form-group">
                            <label>返回类型(首选)</label>
                            <select name="returntype">
                                <?php
                                echo '<option value="application/json"' . ($DATA['returnType'] == 'application/json' ? ' selected' : null) . '>application/json</option>';
                                echo '<option value="text/html"' . ($DATA['returnType'] == 'text/html' ? ' selected' : null) . '>text/html</option>';
                                echo '<option value="text/plain"' . ($DATA['returnType'] == 'text/plain' ? ' selected' : null) . '>text/plain</option>';
                                echo '<option value="image"' . ($DATA['returnType'] == 'image' ? ' selected' : null) . '>image</option>';
                                echo '<option value="location"' . ($DATA['returnType'] == 'location' ? ' selected' : null) . '>location</option>';
                                echo '<option value="video"' . ($DATA['returnType'] == 'video' ? ' selected' : null) . '>video</option>';
                                echo '<option value="audio"' . ($DATA['returnType'] == 'audio' ? ' selected' : null) . '>audio</option>';
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>请求示例</label>
                            <input class="form-control" name="requesttemp" type="text" placeholder="?msg=helloworld" value="<?php echo $DATA['requestTemp']; ?>" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label>请求方式</label>
                            <select name="requesttype">
                                <?php
                                echo '<option value="GET"' . ($DATA['requestType'] == 'GET' ? ' selected' : null) . '>GET</option>';
                                echo '<option value="POST"' . ($DATA['requestType'] == 'POST' ? ' selected' : null) . '>POST</option>';
                                echo '<option value="GET/POST"' . ($DATA['requestType'] == 'GET/POST' ? ' selected' : null) . '>GET/POST</option>';
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>返回参数设置</label>
                            <input class="form-control" name="returnpar" type="text" value="<?php echo $DATA['returnPar'] == null ? '' : htmlentities($DATA['returnPar']); ?>" autocomplete="off">
                        </div>

                        <div class="form-group">
                            <label>请求参数设置</label>
                            <input class="form-control" name="requestpar" type="text" value="<?php echo $DATA['requestPar'] == null ? '' : htmlentities($DATA['requestPar']); ?>" autocomplete="off">
                        </div>

                        <div class="form-group">
                            <label>状态码设置</label>
                            <input class="form-control" name="codepar" type="text" value="<?php echo $DATA['codePar'] == null ? '' : htmlentities($DATA['codePar']); ?>" autocomplete="off">
                        </div>

                        <div class="form-group">
                            <label>代码示例</label>
                            <!--                             <select name="codetemp">
                                <?php
                                /* echo '<option value="0"' . ($DATA['codeTemp'] == '0' ? ' selected' : null) . '>无</option>';
                                echo '<option value="1"' . ($DATA['codeTemp'] == '1' ? ' selected' : null) . '>直接返回图片/视频/音频/文件</option>';
                                echo '<option value="2"' . ($DATA['codeTemp'] == '2' ? ' selected' : null) . '>网页</option>';
                                echo '<option value="4"' . ($DATA['codeTemp'] != '0' && $DATA['codeTemp'] != '1' && $DATA['codeTemp'] != '2' ? ' selected' : null) . '>自定义</option>';
                                 */ ?>
                            </select>
                            <label></label> -->
                            <textarea class="form-control" name="codetempcustom" rows='4' placeholder="将受返回类型属性的影响" autocomplete="off"><?php echo $DATA['codeTemp']; ?></textarea>
                        </div>


                        <div class="form-group">
                            <label>接口价格</label>
                            <input class="form-control" name="coin" type="text" value="<?php echo $DATA['coin']; ?>" autocomplete="off">
                        </div>
                    </div>

                    <div class="tile-footer">
                        <input type="hidden" style="display: none">
                        <button lay-submit lay-filter="apiedit" type="button" class="btn btn-primary">编辑</button>
                    </div>
                </div>
        </form>
    </div>
    </div>

    <script src="//unpkg.com/layui@2.6.8/dist/layui.js"></script>
    <script src="/index.php/assets/js/user/index.js"></script>
    <script>
        apiedit();
    </script>
    </body>

    </html>