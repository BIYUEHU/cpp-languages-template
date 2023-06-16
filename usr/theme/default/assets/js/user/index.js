/*** 
 * @Author: Biyuehu biyuehuya@gmail.com
 * @Blog: http://imlolicon.tk
 * @Date: 2023-06-16 14:20:19
 */

layui.use('form', 'table');
const form = layui.form,
    table = layui.table,
    upload = layui.upload,
    element = layui.element,
    $ = layui.jquery;



function printError(back, data) {
    switch (back.code) {
        case 500:
            layer.msg("操作成功", { icon: 1 });
            setTimeout(() => {
                window.location.reload();
            }, 1000);
            break;
        case 501:
            layer.msg("参数不能为空", { icon: 5 });
            break;
        case 502:
            layer.msg("参数错误", { icon: 5 });
            break;
        case 507:
            layer.msg("非法字符串", { icon: 5 });
            break;
        case 508:
            layer.msg("数据库拒绝", { icon: 2 });
            break;
        case 509:
            layer.msg("拒绝请求", { icon: 2 });
            break;
        case 510:
            layer.msg("服务器拒绝", { icon: 2 });
            break;
        case undefined:
            layer.msg('SQL错误', { icon: 4 });
            break;
        default:
            layer.msg(`错误:${back.message}`, { icon: 0 });
    }

    back.code == 500 || console.log(data, back);
}

function sendPostRequest(url, data = {}, callback) {
    if (callback == null) {
        callback = function (d) {
            printError(d, data);
        }
    }
    $.post(url, { ...data }, d => callback(d));
}


/* login */
function doLogin() {
    event.preventDefault();

    const account = $('#account').val();
    const password = $('#password').val();
    const captchaimg = $('#captchaimg').val();
    if (account == '' || password == '' || captchaimg == '') {
        layer.msg('账号密码或验证码不能为空', { icon: 5 });
        return;
    }

    const data = {
        email: account,
        password: password,
        captchaimg: captchaimg
    };

    sendPostRequest(location.href, data, d => {
        switch (d.code) {
            case 500:
                layer.msg(`欢迎登录User:${d.data.name}`, { icon: 6 });
                setTimeout(() => {
                    window.location.href = './';
                }, 1000)
                break;
            case 501:
                layer.msg('账号或密码不能为空', { icon: 5 });
                break;
            case 502:
                layer.msg('账号或密码错误', { icon: 2 });
                $('#captchaimgImg').attr('src', '/sys/captchaimg');
                break;
            case 510:
                layer.msg('验证码错误', { icon: 0 });
                $('#captchaimgImg').attr('src', '/sys/captchaimg');
                break;
            default:
                printError(d, data);
        }
    });
}


/* apilist */
function apilist_user() {
    tableDemo = table.render({
        elem: '#demo',
        url: './apilist',
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
            [
                {
                    field: 'title', title: '接口'
                },
                {
                    field: 'subtitle', title: '介绍'
                },
                {
                    field: 'idstr', title: 'ID', width: 90
                },
                {
                    field: 'apikey', title: 'Apikey'
                },
                {
                    field: 'stat', title: '调用次数', sort: true
                },
                {
                    field: 'ctime', title: '到期时间', width: 160, sort: true
                },
                {
                    title: '操作', width: 180, templet: () => {
                        return `<button class="layui-btn layui-btn-warm layui-btn-xs" lay-event="reset">重置</button>
                        <button class="layui-btn layui-btn-primary layui-btn-xs" lay-event="copy">复制</button>
                        <button class="layui-btn layui-btn layui-btn-xs" lay-event="continue">续费</button>`;
                    }
                },
            ]
        ]
    });

    table.on('tool(nowline)', (obj) => {
        switch (obj.event) {
            case 'reset':
                layer.confirm("确定要重置密钥吗?", {
                    icon: 3,
                    title: '提示'
                }, index => {
                    const data = {
                        idstr: obj.data.idstr
                    };
                    sendPostRequest('./apilistreset', data, d => {
                        switch (d.code) {
                            case 500:
                                layer.close(index);
                                tableDemo.reload();
                                layer.msg('重置成功', { icon: 1 });
                                break;
                            default:
                                printError(d, data);
                        }
                    });
                })
                break;
            case 'copy':
                navigator.clipboard.writeText(obj.data.apikey).then(() => {
                    layer.msg('复制成功', { icon: 1 });
                }, () => {
                    layer.msg('复制失败', { icon: 5 });
                });
                break;
            case 'continue':
                // layer.msg('暂不支持', {icon: 0 });
                const data = {
                    idstr: obj.data.idstr
                }
                sendPostRequest('./apilistcontinue', data, d => {
                    console.log(d)
                    switch (d.code) {
                        case 500:
                            tableDemo.reload();
                            layer.msg('续费成功', { icon: 1 });
                            break;
                        case 510:
                            layer.msg('接口尚未到期或金额不足', { icon: 5 })
                            break;
                        default:
                            printError(d, data);
                    }
                })
                break;
        }
    })
}


/* apishop */
function apishop() {
    tableDemo = table.render({
        elem: '#demo',
        url: './apishop',
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
            [
                {
                    field: 'title', title: '接口', sort: true
                },
                {
                    field: 'subtitle', title: '介绍'
                },
                {
                    field: 'idstr', title: 'ID', width: 90
                },
                {
                    field: 'coin', title: '价格', width: 80, sort: true
                },
                {
                    title: '操作', width: 80, templet: () => {
                        return `<button class="layui-btn layui-btn layui-btn-xs" lay-event="buy">购买</button>`;
                    }
                },
            ]
        ]
    });

    table.on('tool(nowline)', (obj) => {
        switch (obj.event) {
            case 'buy':
                layer.confirm(`确定要花费<span class="set-accent-color">${obj.data.coin} Coin</span>购买吗?`, {
                    icon: 3,
                    title: '提示'
                }, index => {
                    const data = {
                        idstr: obj.data.idstr
                    };
                    sendPostRequest('./apishopbuy', data, d => {
                        switch (d.code) {
                            case 500:
                                layer.close(index);
                                layer.msg('购买成功<br><a href="./apilist" class="set-accent-color">点击跳转</a>');
                                break;
                            case 502:
                                layer.close(index);
                                layer.msg('购买失败:已购买或金额不足', { icon: 2 });
                                break;
                            default:
                                printError(d, data);
                        }
                    });
                })
                break;
        }
    })
}


/* person */
function person() {
    event.preventDefault();

    const password = $('#password').val();
    const passwordnew = $('#passwordnew').val();
    const passwordnewago = $('#passwordnewago').val();

    if (!(password && passwordnew && passwordnewago)) {
        layer.msg('密码不可为空', { icon: 5 });
        return;
    }

    if (passwordnew != passwordnewago) {
        layer.msg('两次密码输入不一致', { icon: 2 });
        return;
    }

    const data = {
        password: password,
        passwordnew: passwordnew
    }

    sendPostRequest('./person', data, d => {
        switch (d.code) {
            case 500:
                layer.msg('设置成功', { icon: 1 });
                setTimeout(() => {
                    window.location.href = '';
                }, 1000)
                break;
            case 502:
                layer.msg('密码错误', { icon: 2 });
                break;
            default:
                printError(d, data);
        }
    })
}

function person_upload() {
    const uploadInst = upload.render({
        elem: '#uploadavatar',
        url: './personupload',
        done: function (res) {
            //如果上传失败
            switch (res.code) {
                case 500:
                    layer.msg('上传完毕', { icon: 1 });
                    setTimeout(() => {
                        window.location.href = '';
                    }, 1000)
                    break;
                case 510:
                    layer.msg('只支持上传PNG与JPG图片且小于1MB', { icon: 0 });
                    break;
                case 511:
                    layer.msg('上传失败', { icon: 2 });
                    break;
            }
            //上传成功的一些操作
            //……
            $('#demoText').html(''); //置空上传失败的状态
        },
        error: function () {
            //演示失败状态，并实现重传
            var demoText = $('#demoText');
            demoText.html('<span style="color: #FF5722;">上传失败</span> <a class="layui-btn layui-btn-xs demo-reload">重试</a>');
            demoText.find('.demo-reload').on('click', function () {
                uploadInst.upload();
            });
        },
        //进度条
        progress: function (n, elem, e) {
            element.progress('demo', n + '%'); //可配合 layui 进度条元素使用
            if (n == 500) {
                layer.msg('上传完毕', { icon: 1 });
            }
        }
    });
}


/* webset */
function webset_init() {
    layui.use('laydate', function () {
        var laydate = layui.laydate;

        laydate.render({
            elem: '.createtime'
        });
    });
}

function webset() {
    const data = {};
    $("[id=sets]").each(function () {
        data[$(this).attr('setval')] = $(this).val();
    })
    sendPostRequest("./webset", data);
}


/* apiadd */
function apiadd() {
    form.on('submit(apiadd)', (obj) => {
        objData = obj.field;

        if (objData.title == '' || objData.subtitle == '' || objData.idstr == '') {
            layer.msg('必填项不能为空', { icon: 5 });
            return;
        }

        try {
            if (objData['pars0_0_name'] != '' && objData['pars0_0_type'] != '' && objData['pars0_0_descr'] != '') {
                returnpar = `${objData['pars0_0_name']}&${objData['pars0_0_type']}&${objData['pars0_0_descr']}`;
                let pars0Id = 1;
                while (objData[`pars0_${pars0Id}_name`] != '' && typeof (objData[`pars0_${pars0Id}_name`]) == 'string') {
                    if (objData[`pars0_${pars0Id}_name`] != '' && objData[`pars0_${pars0Id}_type`] != '' && objData[`pars0_${pars0Id}_descr`] != '') {
                        returnpar += `|${objData[`pars0_${pars0Id}_name`]}&${objData[`pars0_${pars0Id}_type`]}&${objData[`pars0_${pars0Id}_descr`]}`;
                    }
                    pars0Id++;
                }
            } else {
                returnpar = null;
            }

            if (objData['pars1_0_name'] != '' && objData['pars1_0_if'] != '' && objData['pars1_0_type'] != '' && objData['pars1_0_descr'] != '') {
                requestpar = `${objData['pars1_0_name']}&${objData['pars1_0_if']}&${objData['pars1_0_type']}&${objData['pars1_0_descr']}`;

                let pars1Id = 1;
                while (objData[`pars1_${pars1Id}_name`] != '' && typeof (objData[`pars1_${pars1Id}_name`]) == 'string') {
                    if (objData[`pars1_${pars1Id}_name`] != '' && objData[`pars1_${pars1Id}_if`] != '' && objData[`pars1_${pars1Id}_type`] != '' && objData[`pars1_${pars1Id}_descr`] != '') {
                        requestpar += `|${objData[`pars1_${pars1Id}_name`]}&${objData[`pars1_${pars1Id}_if`]}&${objData[`pars1_${pars1Id}_type`]}&${objData[`pars1_${pars1Id}_descr`]}`;
                    }
                    pars1Id++;
                }
            } else {
                requestpar = null;
            }

            if (objData['pars2_0_name'] != '' && objData['pars2_0_descr'] != '') {
                codepar = `${objData['pars2_0_name']}&${objData['pars2_0_descr']}`;

                let pars2Id = 1;
                while (objData[`pars2_${pars2Id}_name`] != '' && typeof (objData[`pars2_${pars2Id}_name`]) == 'string') {
                    if (objData[`pars2_${pars2Id}_name`] != '' && objData[`pars2_${pars2Id}_descr`] != '') {
                        codepar += `${objData['pars2_0_name']}&${objData['pars2_0_descr']}`;
                    }
                    pars2Id++;
                }
            } else {
                codepar = null;
            }

            objData.returntype != 'application/json' || (JSON.parse(objData.returntemp));

            const data = {
                title: objData.title,
                subtitle: objData.subtitle,
                idstr: objData.idstr,
                state: parseInt(objData.state),
                returnTemp: objData.returntemp,
                returnType: objData.returntype,
                returnPar: returnpar,
                requestTemp: objData.requesttemp,
                requestType: objData.requesttype,
                requestPar: requestpar,
                codeTemp: objData.codetemp,
                codePar: codepar
            };
            sendPostRequest('./apiadd', data);
        } catch (err) {
            layer.msg(`错误:${err}`, { icon: 0 });
            return;
        }
    });
}

function apiadd_parsDel(val) {
    switch (val) {
        case 0:
            if (pars0Id > 0) {
                $(`.pars0_${pars0Id}`).remove();
                pars0Id--;
            }
            break;
        case 1:
            if (pars1Id > 0) {
                $(`.pars1_${pars1Id}`).remove();
                pars1Id--;
            }
            break;
        case 2:
            if (pars2Id > 0) {
                $(`.pars2_${pars2Id}`).remove();
                pars2Id--;
            }
            break;
    }
}


/* apiedit */
function apiedit() {
    form.on('submit(apiedit)', (obj) => {
        objData = obj.field;

        id = ((url) => {
            const str = url.substr(url.indexOf('?') + 1);
            const arr = str.split('&');
            const result = {}
            for (let i = 0; i < arr.length; i++) {
                const item = arr[i].split('=')
                result[item[0]] = item[1]
            }
            return result;
        })(location.href)['id'];

        if (objData.id == '' || objData.name == '' || objData.email == '' || objData.opgroup == '') {
            layer.msg('必填项不能为空', { icon: 5 });
            return;
        }


        try {
            objData.returntype != 'application/json' || (JSON.parse(objData.returntemp));

            const coin = Number(objData.coin);
            if (coin < 0) {
                layer.msg('金额不能小于0', { icon: 5 });
                return;
            }

            const data = {
                id: id,
                title: objData.title,
                subtitle: objData.subtitle,
                state: parseInt(objData.state),
                returnTemp: objData.returntemp,
                returnType: objData.returntype,
                returnPar: objData.returnpar,
                requestTemp: objData.requesttemp,
                requestType: objData.requesttype,
                requestPar: objData.requestpar,
                codeTemp: objData.codetemp,
                codePar: objData.codepar,
                coin: coin
            };

            sendPostRequest('./apiedit', data, d => {
                switch (d.code) {
                    case 500:
                        layer.closeAll();
                        layer.msg('编辑成功', { icon: 1 });
                        break;
                    default:
                        printError(d, data);
                }
            });
        } catch (err) {
            layer.msg(`错误:${err}`, { icon: 0 });
            return;
        }
    });
}


/* apilist */
function apilist() {
    tableDemo = table.render({
        elem: '#demo',
        url: './apilist',
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
            [
                {
                    field: 'title', title: '标题', sort: true
                },
                {
                    field: 'subtitle', title: '副标题', width: 170
                },
                {
                    field: 'idstr', title: '字符ID', width: 90, sort: true
                },
                {
                    title: '状态', width: 80, sort: true, templet: d => {
                        const list = [
                            '<span style="color:red">维护<span/>',
                            '<span style="color:green">正常<span/>',
                            '<span style="color:blue">外链<span/>',
                            '<span style="color:purple">隐藏<span/>'
                        ];
                        return list[d.state] ?? '';
                    }
                },
                {
                    field: 'returnType', title: '返回类型'
                },
                {
                    field: 'requestType', title: '请求方式'
                },
                {
                    title: '返回示例', templet: d => {
                        return d.returnTemp == 0 || d.returnTemp == '0' ? '<span style="color:blue">网页</span>' : d.returnTemp;
                    }
                },
                {
                    field: 'requestTemp', title: '请求示例'
                },
                /*                 {
                                    title: '代码示例', width: 90, templet: d => {
                                        const list = {
                                            'image': '<span style="color:blue">返回图片</span>',
                                            'video': '<span style="color:blue">返回视频</span>',
                                            'audio': '<span style="color:blue">返回音频</span>',
                                            'file': '<span style="color:blue">返回文件</span>',
                                            'text/html': '<span style="color:blue">网页</span>'
                                        };
                                        return list[d.returnType] ?? d.codeTemp;
                                    }
                                }, */
                {
                    title: '返回参数', templet: d => {
                        return d.returnPar == null ? '<span style="color:red">无</span>' : JSON.stringify(d.returnPar);
                    }
                },
                {
                    title: '请求参数', templet: d => {
                        return d.requestPar == null ? '<span style="color:red">无</span>' : JSON.stringify(d.requestPar);
                    }
                },
                {
                    title: '状态码', templet: d => {
                        return d.codePar == null ? '<span style="color:red">无</span>' : JSON.stringify(d.codePar);
                    }
                },
                {
                    field: 'coin', title: '价格', width: 80, sort: true
                },
                {
                    field: 'reg_date', title: '注册时间', width: 160, sort: true
                },
                {
                    title: '操作', width: 120, templet: () => {
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
                    sendPostRequest('./apilistdel', { idstr: obj.data.idstr }, d => {
                        switch (d.code) {
                            case 500:
                                obj.del();
                                layer.close(index);
                                layer.msg('删除成功', { icon: 1 });
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
                    area: ['80%', '83%'],
                    content: `./apiedit?id=${obj.data.id}&idstr=${obj.data.idstr}`,
                    yes: () => {
                        layer.closeAll();
                    },
                    end: () => {
                        tableDemo.reload();
                    }
                })
                break
        }
    })
}


/* account */
function account() {
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
            [
                {
                    field: 'name', title: '名字'
                },
                {
                    field: 'email', title: '邮箱'
                },
                {
                    title: '权限', width: 80, sort: true, templet: d => {
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
                    field: 'ip', title: 'IP地址',
                },
                {
                    field: 'coin', title: '金额', width: 90
                },
                {
                    field: 'reg_date', title: '注册时间', width: 160, sort: true
                },
                {
                    title: '操作', width: 120, templet: () => {
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
                    sendPostRequest('./accountdel', { id: obj.data.id }, d => {
                        switch (d.code) {
                            case 500:
                                obj.del();
                                layer.close(index);
                                layer.msg('删除成功', { icon: 1 });
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
}

function accountadd_open() {
    layer.open({
        type: 2,
        title: '添加',
        area: ['70%', '75%'],
        content: `./accountadd`,
        yes: () => {
            layer.closeAll();
        },
        end: () => {
            tableDemo.reload();
        }
    });
}

function accountadd() {
    form.on('submit(accountadd)', (obj) => {
        objData = obj.field;

        if (objData.name == '' || objData.email == '' || objData.password == '') {
            layer.msg('必填项不能为空', { icon: 5 });
            return;
        }

        const data = {
            name: objData.name,
            email: objData.email,
            password: objData.password,
            opgroup: parseInt(objData.opgroup),
            ip: objData.ip,
            coin: parseInt(objData.coin)
        };

        sendPostRequest('./accountadd', data);
    });
}

function accountedit() {
    form.on('submit(accountedit)', (obj) => {
        objData = obj.field;

        id = ((url) => {
            const str = url.substr(url.indexOf('?') + 1);
            const arr = str.split('&');
            const result = {}
            for (let i = 0; i < arr.length; i++) {
                const item = arr[i].split('=')
                result[item[0]] = item[1]
            }
            return result;
        })(location.href)['id'];

        if (objData.id == '' || objData.name == '' || objData.email == '') {
            layer.msg('必填项不能为空', { icon: 5 });
            return;
        }


        const data = {
            id: id,
            name: objData.name,
            email: objData.email,
            opgroup: parseInt(objData.opgroup),
            coin: parseInt(objData.coin)
        };

        sendPostRequest('./accountedit', data, d => {
            switch (d.code) {
                case 500:
                    layer.closeAll();
                    layer.msg('编辑成功', { icon: 1 });
                    break;
                default:
                    printError(d, data);
            }
        });
    });
}


/* websafe */
function websafe() {
    const data = {};
    $("[id=sets]").each(function () {
        data[$(this).attr('setval')] = $(this).val();
    })
    sendPostRequest("./websafe", data);
}

function websafelog() {
    tableDemo = table.render({
        elem: '#demo',
        url: './websafelog',
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
            [
                {
                    field: 'ua', title: 'UA'
                },
                {
                    field: 'url', title: '请求链接'
                },
                {
                    field: 'request', title: '请求类型', width: 90
                },
                {
                    field: 'ip', title: 'IP地址', width: 140
                },
                {
                    field: 'date', title: '时间', width: 160, sort: true
                },
            ]
        ]
    });
}


/* themes */
function themes() {
    const data = {};
    $("[id=sets]").each(function () {
        data[$(this).attr('setval')] = $(this).val();
    })
    sendPostRequest("./themes", data);
}


/* plugins */
function plugins_exec() {
    const data = {};
    $("[id=sets]").each(function () {
        data[$(this).attr('setval')] = $(this).val();
    })
    sendPostRequest("./plugins", data);
}

function pluginssendemail() {
    layer.open({
        type: 1,
        title: '发送邮件',
        area: ['90%', '40%'],
        content: $('#pluginssendemaillayer')
    });

    $('#sendemail').click(() => {
        event.preventDefault();

        const reveuser = $('#reveuser').val(),
            title = $('#title').val(),
            message = $('#message').val();

        if (reveuser == '' || title == '' || message == '') {
            layer.msg('必填项不能为空', { icon: 5 });
            return;
        }

        const data = {
            reveuser: reveuser,
            title: title,
            message: message
        };
        sendPostRequest("./pluginssendemail", data, (d) => {
            switch (d.code) {
                case 500:
                    layer.closeAll();
                    layer.msg('发送成功', { icon: 6 });
                    $('#reveuser').val('')
                    $('#title').val('')
                    $('#message').val('')
                    break;
                case 502:
                    layer.msg('发送失败', { icon: 5 });
                    break;
                default:
                    printError(d, data);
            }
        });
    });
}
