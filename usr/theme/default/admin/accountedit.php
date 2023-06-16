<?php
$title = '账户编辑';
include(__DIR__ . '../../user/head.php');
?>

<main>
    <div class="col-md-12">
        <form id="accountedit" class="layui-form">
            <div class="tile">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label><strong>*名字</strong></label>
                            <input class="form-control" name="name" type="text" required value="<?php echo $DATA['name']; ?>" autocomplete="off">
                        </div>

                        <div class="form-group">
                            <label><strong>*邮箱</strong></label>
                            <input class="form-control" name="email" type="text" required value="<?php echo $DATA['email']; ?>" autocomplete="off">
                        </div>

                        <div class="form-group">
                            <label><strong>*权限</strong></label>
                            <select name="opgroup">
                                <?php
                                echo '<option value="1"' . ($DATA['opgroup'] == 1 ? ' selected' : null) . '>封禁</option>';
                                echo '<option value="2"' . ($DATA['opgroup'] == 2 ? ' selected' : null) . '>待验证</option>';
                                echo '<option value="3"' . ($DATA['opgroup'] == 3 ? ' selected' : null) . '>用户</option>';
                                echo '<option value="4"' . ($DATA['opgroup'] == 4 ? ' selected' : null) . '>管理</option>';
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>金额</label>
                            <input class="form-control" name="coin" type="text" placeholder="?msg=helloworld" value="<?php echo $DATA['coin']; ?>" autocomplete="off">
                        </div>
                    </div>

                    <div class="tile-footer">
                        <input type="hidden" style="display: none">
                        <button lay-submit lay-filter="accountedit" type="button" class="btn btn-primary">编辑</button>
                    </div>
                </div>
        </form>
    </div>
    </div>

    <script src="//unpkg.com/layui@2.6.8/dist/layui.js"></script>
    <script src="/index.php/assets/js/user/index.js"></script>
    <script>
        accountedit();
    </script>
    </body>

    </html>