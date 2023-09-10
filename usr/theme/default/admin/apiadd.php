<?php
$title = '接口添加';
include(__DIR__ . '/header.php');
include(__DIR__ . '/nav.php');
?>

<main class="app-content">
    <div class="app-title">
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href=""><?php echo $title;?></a></li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <form id="apiadd" class="layui-form">
                <div class="tile">
                    <div class="bs-component">
                        <div class="alert alert-dismissible alert-success">
                            <input class="close" style="background-color:transparent;border:0;" type="button" value="x" data-dismiss="alert">
                            1.字符ID与标题必须全局唯一,字符ID用做访问识别,建议全部小写<br />
                            2.填写英文引号时建议统一使用双引号而非单引号<br />
                            3.返回类型为image、video、audio时,返回示例直接填写示例的图片/视频/音频等的相对或绝对路径或外部URL<br />
                            4.接口文件请以字符id为文件名上传至<strong>接口文件</strong>目录下,静态接口以字符ID将作为父文件夹名上传至<strong>public/api/</strong>目录下<br />
                            5.接口开发提示:上传的接口文件如果附带其他文件,引用时请在路径前加上 【__DIR__】关键词,例:__DIR__ . "data/xxx/a.png";<br />
                            6.请避免使用某些特殊字符(HTML转义字符、HTML字符、URL解码字符等),否则数据库炸了获取不到数据自己看着办
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label><strong>*标题</strong></label>
                                <input class="form-control" name="title" type="text" required placeholder="短网址生成" autocomplete="off">
                            </div>

                            <div class="form-group">
                                <label><strong>*副标题</strong></label>
                                <input class="form-control" name="subtitle" type="text" required placeholder="将长网址进行缩短" autocomplete="off">
                            </div>

                            <div class="idstr-group">
                                <label><strong>*字符ID</strong></label>
                                <input class="form-control" name="idstr" type="text" required placeholder="shorturl" autocomplete="off">
                            </div>

                            <div class="form-group">
                                <label>状态</label>
                                <select name="state">
                                    <option value="1" selected>well正常</option>
                                    <option value="0">bad维护</option>
                                    <option value="2">out外链</option>
                                    <option value="3">hide隐藏</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>返回示例</label>
                                <textarea class="form-control" name="returntemp" rows="5" placeholder='{
    "code": 500,
    "msg": "success",
    "data": {
        "url": "http://hotaru.icu"
    }
}' autocomplete="off"></textarea>
                            </div>
                            <div class="form-group">
                                <label>返回类型(首选)</label>
                                <select name="returntype">
                                    <option value="application/json" selected>application/json</option>
                                    <option value="text/html">text/html</option>
                                    <option value="text/plain">text/plain</option>
                                    <option value="image">image</option>
                                    <option value="location">location</option>
                                    <option value="video">video</option>
                                    <option value="audio">audio</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>请求示例</label>
                                <input class="form-control" name="requesttemp" type="text" placeholder="?msg=helloworld" autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label>请求方式</label>
                                <select name="requesttype">
                                    <option value="GET">GET</option>
                                    <option value="POST">POST</option>
                                    <option value="GET/POST" selected>GET/POST</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>代码示例</label>
                                <!-- <select name="codetemp">
                                    <option value="0" selected>无</option>
                                    <option value="1">直接返回图片/视频/音频/文件</option>
                                    <option value="2">网页</option>
                                    <option value="3">自定义</option>
                                </select>
                                <label>代码示例自定义</label> -->
                                <textarea class="form-control" name="codetemp" rows='4' placeholder="将受返回类型属性的影响"></textarea>
                            </div>

                            <label style="color:silver"><strong>以下功能暂不可用</strong></label>
                            <div class="form-group">
                                <label>数据接口（判断是否调用自定义数据库数据）</label>
                                <div class="toggle-flip">
                                    <label>
                                        <input style="display:none" />
                                        <input type="checkbox" value="1" lay-skin="switch" lay-text="开|关">
                                    </label>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>接口价格<span class="help-block" style="color:red">
                                        （请添加后在接口列表编辑中设置）</span></label>
                                <div class="toggle-flip">
                                    <label>
                                        <input style="display:none" />
                                        <input type="checkbox" value="1" lay-skin="switch" lay-text="开|关">
                                    </label>
                                </div>
                            </div>

                        </div>

                    </div>

                    <label>返回参数设置</label>
                    <div class="pars0">
                        <div class="pars0_0 row">
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label>参数1:名称</label>
                                    <input class="form-control" name="pars0_0_name" id="pars0_0_name" type="text" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label>类型</label>
                                    <input class="form-control" name="pars0_0_type" id="pars0_0_type" type="text" placeholder="string/number/boolean/array" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>说明</label>
                                    <input class="form-control" name="pars0_0_descr" id="pars0_0_descr" type="text" autocomplete="off">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row" style="text-align: center;width: 100%;display: inline-block;">
                        <a href="javascript:" id="addpars0" name="addpars0">添加新参数</a>
                    </div>
                    <div class="row" style="text-align: center;width: 100%;display: inline-block;">
                        <a href="javascript:apiadd_parsDel(0)">删除一个参数</a>
                    </div>

                    <label>请求参数设置</label>
                    <div class="pars1">
                        <div class="pars1_0 row">
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label>参数1:名称</label>
                                    <input class="form-control" name="pars1_0_name" id="pars1_0_name" type="text" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label>必填</label>
                                    <input class="form-control" name="pars1_0_if" id="pars1_0_if" type="text" placeholder="是/否" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label>类型</label>
                                    <input class="form-control" name="pars1_0_type" id="pars1_0_type" type="text" placeholder="string/number/boolean/array" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-lg-5">
                                <div class="form-group">
                                    <label>说明</label>
                                    <input class="form-control" name="pars1_0_descr" id="pars1_0_descr" type="text" autocomplete="off">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row" style="text-align: center;width: 100%;display: inline-block;">
                        <a href="javascript:" id="addpars1" name="addpars1">添加新参数</a>
                    </div>
                    <div class="row" style="text-align: center;width: 100%;display: inline-block;">
                        <a href="javascript:apiadd_parsDel(1)">删除一个参数</a>
                    </div>

                    <label>状态码设置</label>
                    <div class="pars2">
                        <div class="pars2_0 row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>参数1:名称</label>
                                    <input class="form-control" name="pars2_0_name" id="pars2_0_name" type="text" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>说明</label>
                                    <input class="form-control" name="pars2_0_descr" id="pars2_0_descr" type="text" autocomplete="off">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row" style="text-align: center;width: 100%;display: inline-block;">
                        <a href="javascript:" id="addpars2" name="addpars2">添加新参数</a>
                    </div>
                    <div class="row" style="text-align: center;width: 100%;display: inline-block;">
                        <a href="javascript:apiadd_parsDel(2)">删除一个参数</a>
                    </div>

                    <div class="tile-footer">
                        <input type="hidden" style="display: none">
                        <button lay-submit lay-filter="apiadd" type="button" class="btn btn-primary">添加</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <?php include(__DIR__ . '.../../user/footer.php'); ?>

    <script>
        apiadd();

        let pars0Id = 0;
        let pars1Id = 0;
        let pars2Id = 0;
        $("#addpars0").click(() => {
            pars0Id++;
            $(".pars0").append(
                `<div class="pars0_${pars0Id} row">
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label>参数${((pars0Id - 0) + 1)}:名称</label>
                            <input class="form-control" name="pars0_${pars0Id}_name" id="pars0_${pars0Id}_name" type="text" autocomplete="off">
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label>类型</label>
                            <input class="form-control" name="pars0_${pars0Id}_type" id="pars0_${pars0Id}_type" type="text" autocomplete="off">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>说明</label>
                            <input class="form-control" name="pars0_${pars0Id}_descr" id="pars0_${pars0Id}_descr" type="text"autocomplete="off">
                        </div>
                    </div>
                </div>`
            );
        });

        $("#addpars1").click(() => {
            pars1Id++;
            $(".pars1").append(
                `<div class="pars1_${pars1Id} row">
                    <div class="col-lg-2">
                        <div class="form-group">
                            <label>参数${((pars1Id - 0) + 1)}:名称</label>
                            <input class="form-control" name="pars1_${pars1Id}_name" id="pars1_${pars1Id}_name" type="text" autocomplete="off">
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="form-group">
                            <label>必填</label>    
                            <input class="form-control" name="pars1_${pars1Id}_if" id="pars1_${pars1Id}_if" type="text" autocomplete="off">
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label>类型</label>
                            <input class="form-control" name="pars1_${pars1Id}_type" id="pars1_${pars1Id}_type" type="text" autocomplete="off">
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="form-group">
                            <label>说明</label>
                            <input class="form-control" name="pars1_${pars1Id}_descr" id="pars1_${pars1Id}_descr" type="text" autocomplete="off">
                        </div>
                    </div>
                </div>`
            );
        });

        $("#addpars2").click(() => {
            pars2Id++;
            $(".pars2").append(
                `<div class="pars2_${pars2Id} row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>参数${((pars2Id - 0) + 1)}:名称</label>
                            <input class="form-control" name="pars2_${pars2Id}_name" id="pars2_${pars2Id}_name" type="text" autocomplete="off">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>说明</label>
                            <input class="form-control" name="pars2_${pars2Id}_descr" id="pars2_${pars2Id}_descr" type="text" autocomplete="off">
                        </div>
                    </div>
                </div>`
            );
        });
    </script>
    </body>

    </html>