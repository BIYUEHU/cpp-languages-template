<?php
$title = '账户管理';
include(__DIR__ . '/header.php');
include(__DIR__ . '/nav.php');
?>

<main class="app-content">
    <div class="app-title">
        <ul class="app-breadcrumb breadcrumb side">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href=""><?php echo $title; ?></a></li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <button type="button" class="btn btn-primary" onclick="accountadd_open()">添加</button>
                <div class="tile-body">
                    <table id="demo" lay-filter="nowline"></table>
                </div>
            </div>
        </div>
    </div>

    <?php
    include(__DIR__ . '.../../user/footer.php');
    ?>

    <? if ($CONFIG['type'] == 'HotaruCore') : ?>
        <script>
            tableDemo = table.render({
                elem: '#demo',
                url: './account',
                method: 'post',
                page: true,
                limit: 10,
                limits: [10, 20, 30],
                parseData: (res) => {
                    return {
                        "code": 0,
                        "msg": "",
                        "count": res.data[0],
                        "data": res.data[1]
                    };
                },
                cols: [
                    [{
                            field: 'name',
                            title: '名字'
                        },
                        {
                            field: 'email',
                            title: '邮箱'
                        },
                        {
                            title: '权限',
                            width: 80,
                            sort: true,
                            templet: d => {
                                const list = [
                                    null,
                                    '<span style="color:black">封禁<span/>',
                                    '<span style="color:glay">待验证<span/>',
                                    '<span style="color:green">用户<span/>',
                                    '<span style="color:orange">管理<span/>',
                                    // '<span style="color:deepskyblue">超管<span/>'
                                ];
                                return list[d.opgroup] ?? '<span style="color:black">封禁<span/>';
                            }
                        },
                        {
                            field: 'ip',
                            title: 'IP地址',
                        },
                        {
                            field: 'coin',
                            title: '金额',
                            width: 90
                        },
                        {
                            field: 'website',
                            title: '站点'
                        },
                        {
                            field: 'nums',
                            title: '接口数量'
                        },
                        {
                            field: 'call',
                            title: '调用次数'
                        },
                        {
                            field: 'reg_date',
                            title: '注册时间',
                            width: 160,
                            sort: true
                        },
                        {
                            title: '操作',
                            width: 120,
                            templet: () => {
                                return `<button class="layui-btn layui-btn-normal layui-btn-xs" lay-event="edit">编辑</button>
                    <button class="layui-btn layui-btn-warm layui-btn-xs" lay-event="del">删除</button>`;
                            }
                        },
                    ]
                ]
            });

            table.on('tool(nowline)', (obj) => {
                switch (obj.event) {
                    case 'del':
                        layer.confirm("确定要删除?", {
                            icon: 3,
                            title: '提示'
                        }, index => {
                            sendPostRequest('./accountdel', {
                                id: obj.data.id
                            }, d => {
                                switch (d.code) {
                                    case 500:
                                        obj.del();
                                        layer.close(index);
                                        layer.msg('删除成功', {
                                            icon: 1
                                        });
                                        break;
                                    default:
                                        printError(d, data);
                                }
                            });
                        })
                        break;
                    case 'edit':
                        layer.open({
                            type: 2,
                            title: '编辑',
                            area: ['70%', '70%'],
                            content: `./accountedit?id=${obj.data.id}`,
                            yes: () => {
                                layer.closeAll();
                            },
                            end: () => {
                                tableDemo.reload();
                            }
                        });
                        break
                }
            })
        </script>
    <? else : ?>
        <script>
            account();
        </script>
    <? endif; ?>
    </body>

    </html>