<?php
$title = '账户添加';
include(__DIR__ . '../../user/head.php');
?>

<main>
    <div class="col-md-12">
        <form id="accountadd" class="layui-form">
            <div class="tile">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label><strong>*名字</strong></label>
                            <input class="form-control" name="name" type="text" required autocomplete="off">
                        </div>

                        <div class="form-group">
                            <label><strong>*邮箱</strong></label>
                            <input class="form-control" name="email" type="text" required autocomplete="off">
                        </div>

                        <div class="form-group">
                            <label><strong>*密码</strong></label>
                            <input class="form-control" name="password" type="text" required autocomplete="off">
                        </div>

                        <div class="form-group">
                            <label><strong>*权限</strong></label>
                            <select name="opgroup">
                                <option value="0">待验证</option>';
                                <option value="1" selected>用户</option>';
                                <option value="2">管理</option>';
                                <option value="-1">封禁</option>';
                            </select>
                        </div>
                        <div class="form-group">
                            <label>IP</label>
                            <input class="form-control" name="ip" type="text" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label>金额</label>
                            <input class="form-control" name="coin" type="text" autocomplete="off">
                        </div>
                    </div>

                    <div class="tile-footer">
                        <input type="hidden" style="display: none">
                        <button lay-submit lay-filter="accountadd" type="button" class="btn btn-primary">添加</button>
                    </div>
                </div>
        </form>
    </div>
    </div>

    <script src="//cdn.staticfile.org/layui/2.8.7/layui.js"></script>
    <script src="<? echo $CONFIG['path'] ?>/js/user/index.js"></script>
    <script>
        accountadd();
    </script>
    </body>

    </html>