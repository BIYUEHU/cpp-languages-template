<?php
$title = '接口列表';
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
                <button type="button" class="btn btn-primary" id="addhitokotodata">添加</button>
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
        layui.use(['table', 'layer', 'form'], () => {
            const table = layui.table,
                layer = layui.layer,
                form = layui.form,
                $ = layui.jquery;

            const tableDemo = table.render({
                elem: '#demo',
                url: './api/getHitokotoData',
                method: 'POST',
                page: true,
                limit: 10,
                limits: [10, 20, 30],
                parseData: (res) => {
                    return {
                        "code": 0,
                        "msg": "",
                        "count": res.count,
                        "data": res.data
                    };
                },
                cols: [
                    [{
                            field: 'id',
                            title: 'ID',
                            width: 60,
                            sort: true
                        },
                        {
                            field: 'msg',
                            title: '语录'
                        },
                        {
                            field: 'from',
                            title: '来自',
                            width: 210,
                        },
                        {
                            field: 'reg_date',
                            title: '注册时间',
                            width: 180,
                            sort: true
                        },
                        {
                            title: '操作',
                            width: 70,
                            templet: () => {
                                return `<button class="layui-btn layui-btn-warm layui-btn-xs" lay-event="del">删除</button>`;
                            }
                        }
                    ]
                ]
            });

            table.on('tool(nowline)', (obj) => {
                switch (obj.event) {
                    case 'del':
                        console.log('a');
                        layer.confirm("确定要删除?", {
                            icon: 3,
                            title: '提示'
                        }, index => {
                            $.post("./api/delHitokotoData", {
                                id: obj.data.id
                            }, d => {
                                if (d.code != 500) {
                                    layer.msg('删除失败');
                                } else {
                                    obj.del();
                                    layer.close(index);
                                    layer.msg('删除成功');
                                }
                            })
                        })
                        break;
                }
            });

            $('#addhitokotodata').click(() => {
                layer.open({
                    type: 1,
                    title: '添加语录',
                    area: ['90%', '40%'],
                    content: `<form class="layui-form" style="margin-top: 20px">
                                <div class="layui-form-item">
                                    <label class="layui-form-label">语录</label>
                                    <div class="layui-input-block">
                                        <input type="text" id="msg" required lay-verify="required" class="layui-input" />
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label class="layui-form-label">来源</label>
                                    <div class="layui-input-block">
                                        <input type="text" id="from" required lay-verify="required" class="layui-input" />
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <div class="layui-input-block">
                                        <button class="layui-btn layui-btn-normal" lay-submit lay-filter="addhitokotodata">确定</button>
                                        <button type="reset" class="layui-btn layui-btn-primary">重置</button>
                                    </div>
                                </div>
                    </form>`
                })
            });

            form.on('submit(addhitokotodata)', (obj) => {
                objData = obj.field;
                if (objData.msg == '' || objData.from == '') {
                    layer.msg('必填项不能为空！');
                    return false;
                }

                const data = {
                    msg: objData.msg,
                    from: objData.from
                };

                $.post("./api/addHitokotoData", {
                    ...data
                }, d => {
                    if (d.code != 500) {
                        layer.msg(`添加失败:${d.message}`);
                    } else {
                        tableDemo.reload();
                        layer.closeAll();
                        layer.msg('添加成功');
                    }
                });

                return false;
            })
        });
    </script>
    </body>

    </html>