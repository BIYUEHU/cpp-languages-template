<?php

use function Core\Func\getAllFiles;

$title = '文件上传';
include(__DIR__ . '/header.php');
include(__DIR__ . '/nav.php');
?>

<main class="app-content">
    <div class="app-title">
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item">
                <i class="fa fa-home fa-lg"></i>
            </li>
            <li class="breadcrumb-item"><a href=""><?php echo $title; ?></a></li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="bs-component">
                    <div class="alert alert-dismissible alert-success">
                        <button class="close" type="button" data-dismiss="alert">×</button>
                        1.上传前文件名字请与对应接口字符id一致<br />
                        2.上传接口文件默认存放在/data/api/目录下<br />
                        3.编辑文件内容框留空默认删除当前编辑的文件<br />
                        4.仅支持单一接口文件,如若有额外文件或为JS静态接口请手动上传,静态接口以字符ID将作为父文件夹名上传至public/api/目录下<br />
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="layui-upload">
                                <button type="button" class="layui-btn demo-class-accept" id="uploadfile">上传文件</button>
                                <div style="width: 95px;">
                                    <div class="layui-progress layui-progress-big" lay-showpercent="yes" lay-filter="demo">
                                        <div class="layui-progress-bar" lay-percent=""></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>选择文件</label><br>
                            <select id="fileslist" class="layui-btn demo1 layui-icon">
                                <?php
                                foreach (getAllFiles(HULICORE_DATA_PATH . '/api/') as $val) {
                                    echo "<option class=\"layui-btn demo1\" value=\"$val\">$val</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>编辑文件</label>
                            <textarea class="form-control" name="filecontent" id="filecontent" setval="openEjct" rows="15" autocomplete="off"></textarea>
                        </div>
                    </div>
                </div>
                <div class="tile-footer">
                    <input value="webinfo" style="display: none">
                    <button type="button" class="btn btn-primary" onclick="fileupload_save()">保存</button>
                </div>
            </div>
            </form>
        </div>
    </div>

    <?php include(__DIR__ . '.../../user/footer.php'); ?>

    <!--  <link rel="stylesheet" href="https://cdn.staticfile.org/codemirror/6.65.7/codemirror.css">
    <link rel="stylesheet" href="https://cdn.staticfile.org/codemirror/6.65.7/addon/mode/simple.min.js">
    <script src="https://cdn.staticfile.org/codemirror/6.65.7/codemirror.js"></script>
    <script src="https://cdn.staticfile.org/codemirror/6.65.7/addon/mode/simple.js"></script>
    <script src="https://cdn.staticfile.org/codemirror/6.65.7/addon/hint/javascript-hint.js"></script>
    <script src="https://cdn.staticfile.org/codemirror/6.65.7/mode/php/php.js"></script> -->
    <script>
        fileupload();
/*         var editor = CodeMirror.fromTextArea(document.getElementById("filecontent"), {
            lineNumbers: true,
            extraKeys: {
                "Ctrl-Space": function(cm) {
                    CodeMirror.simpleHint(cm, CodeMirror.javascriptHint);
                }
            }
        });
        $(".CodeMirror-scroll").hover(function() {
            $(this).get(0).style.cursor = "text";
        }); */
    </script>
    </body>

    </html>