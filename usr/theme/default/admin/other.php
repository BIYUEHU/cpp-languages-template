<?php

use Lib\Stat;

$title = '扩展 - IAL';
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
                <li class="breadcrumb-item"><strong>调用数据</strong></li>
                <?php
                $seimg_ialapi = Stat::QueryTag('seimg_ialapi');
                $seimg_ialapi_day = Stat::QueryDayTag('seimg_ialapi');
                $seimg_ialapi_yday = Stat::QueryDayTag('seimg_ialapi', 1);
                $hitokoto_ialapi = Stat::QueryTag('hitokoto_ialapi');
                $hitokoto_ialapi_day = Stat::QueryDayTag('hitokoto_ialapi');
                $hitokoto_ialapi_yday = Stat::QueryDayTag('hitokoto_ialapi', 1);
                $index_hcb = Stat::QueryTag('index_hcb');
                $index_hcb_day = Stat::QueryDayTag('index_hcb');
                $index_hcb_yday = Stat::QueryDayTag('index_hcb', 1);

                echo "<p>随机色图(seimg)-IALAPI 总计:{$seimg_ialapi} 今日:{$seimg_ialapi_day} 昨日:{$seimg_ialapi_yday} 趋势:<span style=\"color:" . ($seimg_ialapi_day > $seimg_ialapi_yday ? "#33FF00\">↑" : "#FF0033\">↓") . floor($seimg_ialapi_day - $seimg_ialapi_yday) . "%</span></p>
                <p>糊一言(hitokoto)-IALAPI 总计:{$hitokoto_ialapi} 今日:{$hitokoto_ialapi_day} 昨日:{$hitokoto_ialapi_yday} 趋势:<span style=\"color:" . ($hitokoto_ialapi_day > $hitokoto_ialapi_yday ? "#33FF00\">↑" : "#FF0033\">↓") . floor($hitokoto_ialapi_day - $hitokoto_ialapi_yday) . "%</span></p>
                <p>HULI云黑 总计:{$index_hcb} 今日:{$index_hcb_day} 昨日:{$index_hcb_yday} 趋势:<span style=\"color:" . ($index_hcb_day > $index_hcb_yday ? "#33FF00\">↑" : "#FF0033\">↓") . floor($index_hcb_day - $index_hcb_yday) . "%</span></p>";
                ?>
                <li class="breadcrumb-item"><strong>存储数据</strong></li>
                <div id="databasenums"></div><br>
                <div class="row" style="margin-bottom: 30px;">
                    <div class="col-md-6 ptch-index-info">
                        <div class="layui-card ptch-overflow-y" style="height: auto">
                            <div id="e-seimg" style="height:300px;"></div>
                        </div>
                    </div>

                    <div class="col-md-6 ptch-index-info">
                        <div class="layui-card ptch-overflow-y" style="height: auto">
                            <div id="e-hitokoto" style="height:300px;"></div>
                        </div>
                    </div>
                </div>

                <span class="cc" id="count"></span>
                <hr>
                <li class="breadcrumb-item">HuHitokoto</li><br>
                <button type="button" class="btn btn-primary" id="hitokotoadd">添加</button>
                <div class="tile-body">
                    <table id="demo" lay-filter="nowline"></table>
                </div>
            </div>
        </div>
    </div>

    <div style="position: absolute;top: -9999px;left: -9999px">
        <form class="layui-form" id="hitokotoaddlayer" style="margin-top: 20px;width: 95%">
            <div class="layui-form-item">
                <label class="layui-form-label">语录</label>
                <div class="layui-input-block">
                    <input autocomplete="off" type="text" id="msg" lay-verify="required" class="layui-input" />
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">来源</label>
                <div class="layui-input-block">
                    <input autocomplete="off" type="text" id="from" lay-verify="required" class="layui-input" />
                </div>
            </div>
            <div class="layui-form-item from-group">
                <label class="layui-form-label">类型</label>
                <div class="layui-input-block">
                    <select id="type">
                        <option value="1" selected>ACG</option>
                        <option value="2">文学</option>
                        <option value="3">俗语</option>
                        <option value="4">杂类</option>
                    </select>
                </div>
            </div>
            <div class="layui-form-item from-group">
                <label class="layui-form-label">显示</label>
                <div class="layui-input-block">
                    <select id="view">
                        <option value="0" style="color:red" selected>隐藏</option>
                        <option value="1" style="color:lightgreen">公开</option>
                    </select>
                </div>
            </div>
            <div class="layui-form-item">
                <div class="layui-input-block">
                    <button class="layui-btn layui-btn-normal" lay-submit onclick="hitokotoadd()">确定</button>
                    <button type="reset" class="layui-btn layui-btn-primary">重置</button>
                </div>
            </div>
        </form>
    </div>

    <?php
    include(__DIR__ . '.../../user/footer.php');
    ?>

    <script src="//cdn.staticfile.org/echarts/5.4.2/echarts.min.js"></script>
    <script>
        const tableDemo = table.render({
            elem: '#demo',
            url: './other/hitokotoget',
            method: 'POST',
            page: true,
            limit: 10,
            limits: [10, 20, 30],
            parseData: (res) => {
                let data = res.data;
                let other = data[2];
                $('#database-info').append(`Seimg总计:${other.seimg[0]} Hitokoto总计:${data[0]}`);
                echartsRender2('e-hitokoto', 'Hitokoto数据', '', [
                    {value: other.hitokoto[0], name: 'ACG'},
                    {value: other.hitokoto[1], name: '文学'},
                    {value: other.hitokoto[2], name: '俗语'},
                    {value: other.hitokoto[3], name: '杂类'}
                ]);
                echartsRender2('e-seimg', 'Seimg数据', '', [
                    {value: other.seimg[1], name: '非R18'},
                    {value: other.seimg[2], name: 'R18'}
                ]);

                return {
                    "code": 0,
                    "msg": "",
                    "count": data[0],
                    "data": data[1]
                };
            },
            cols: [
                [
                    {field: 'msg', title: '语录'},
                    {field: 'from', title: '来源', width: 210},
                    {title: '类型', width: 70, templet: d => {
                        const list = [null, 'ACG', '文学', '俗语', '杂类'];
                        return list[d.type];
                    }},
                    {field: 'likes', title: '点赞', width: 70, sort: true},
                    {field: 'view', title: '显示', width: 60, templet: d => {
                        return  d.view ? `<span style="color:lightgreen">公开</span>` : `<span style="color:red">隐藏</span>`;
                    }},
                    {field: 'reg_date', title: '添加时间', width: 180, sort: true},
                    {
                        title: '操作',
                        width: 115,
                        templet: () => {
                            return `<button class="layui-btn layui-btn layui-btn-xs" lay-event="change">改变</button>
                            <button class="layui-btn layui-btn-warm layui-btn-xs" lay-event="del">删除</button>`;
                        }
                    }
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
                        $.post("./other/hitokotodel", {
                            msg: obj.data.msg
                        }, d => {
                            switch (d.code) {
                                case 500:
                                    obj.del();
                                    layer.close(index);
                                    layer.msg('删除成功');
                                    break;
                                default:
                                    layer.msg('删除失败');
                                    console.log(data, d);
                            }
                        })
                    })
                    break;
                case 'change':
                    $.post("./other/hitokotochange", {
                        msg: obj.data.msg,
                        set: obj.data.view ? 0 : 1
                    }, d => {
                        switch (d.code) {
                            case 500:
                                let value = obj.data.view !== true ? `<span style="color:lightgreen">公开</span>` : `<span style="color:red">隐藏</span>`;
                                obj.update({
                                    view: value
                                });
                                layer.msg(`操作成功 改变为:${value}`);
                                break;
                            default:
                                layer.msg('操作失败');
                                console.log(data, d);
                        }
                    })
            }
        });

        $('#hitokotoadd').click(() => {
            layer.open({
                type: 1,
                title: '添加语录',
                area: ['90%', '55%'],
                content: $('#hitokotoaddlayer')
            })
        });

        function hitokotoadd() {
            event.preventDefault();

            const data = {
                msg: $('#msg').val(),
                from: $('#from').val(),
                type: $('#type').val(),
                view: $('#view').val()
            };

            if (!(data.msg && data.from && from.type)) {
                return;
            }

            $.post("./other/hitokotoadd", {
                ...data
            }, d => {
                switch (d.code) {
                    case 500:
                        tableDemo.reload();
                        layer.closeAll();
                        layer.msg('添加成功');
                        $('#msg').val('');
                        $('#from').val('');
                        $('#type').val('');
                        break;
                    case 508:
                        layer.closeAll();
                        layer.msg('不可重复添加');
                        break;
                    default:
                        layer.msg('添加失败');
                        console.log(data, d);
                }
            });
            return false;
        }
    </script>
    </body>

    </html>