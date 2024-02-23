/* 鼠标点击效果 */
function clickEffect() {
    var coreSocialistValues = ["🤣", "😋", "😃", "😥", "😅", "😍", "🥰", "😄", "🤗", "🤡"],
        index = Math.floor(Math.random() * coreSocialistValues.length);

    document.body.addEventListener('click', function (e) {
        if (e.target.tagName == 'A') {
            return;
        }
        var x = e.pageX,
            y = e.pageY,
            span = document.createElement('span');
        span.textContent = coreSocialistValues[index];
        index = (index + 1) % coreSocialistValues.length;
        span.style.cssText = ['z-index: 9999999; position: absolute; font-weight: bold; color: #ff6651; top: ', y - 20, 'px; left: ', x, 'px;'].join('');
        document.body.appendChild(span);
        animate(span);
    });

    function animate(el) {
        var i = 0,
            top = parseInt(el.style.top),
            id = setInterval(frame, 16.7);

        function frame() {
            if (i > 180) {
                clearInterval(id);
                el.parentNode.removeChild(el);
            } else {
                i += 2;
                el.style.top = top - i + 'px';
                el.style.opacity = (180 - i) / 180;
            }
        }
    }
}


/* 时间显示 */
function showLocale(objD) {
    var str, colorhead, colorfoot;
    var yy = objD.getYear();
    if (yy < 1900) yy = yy + 1900;
    var MM = objD.getMonth() + 1;
    if (MM < 10) MM = '0' + MM;
    var dd = objD.getDate();
    if (dd < 10) dd = '0' + dd;
    var hh = objD.getHours();
    if (hh < 10) hh = '0' + hh;
    var mm = objD.getMinutes();
    if (mm < 10) mm = '0' + mm;
    var ss = objD.getSeconds();
    if (ss < 10) ss = '0' + ss;
    var ww = objD.getDay();
    if (ww == 0) colorhead = "<font color=\"#FF3030\">";
    if (ww > 0 && ww < 6) colorhead = "<font color=\"#FF3030\">";
    if (ww == 6) colorhead = "<font color=\"#FF3030\">";
    if (ww == 0) ww = "Sunday";
    if (ww == 1) ww = "Monday";
    if (ww == 2) ww = "Tuesday";
    if (ww == 3) ww = "Wednesday";
    if (ww == 4) ww = "Thursday";
    if (ww == 5) ww = "Friday";
    if (ww == 6) ww = "Saturday";
    colorfoot = "</font>"
    str = colorhead + yy + "-" + MM + "-" + dd + "丨" + hh + ":" + mm + ":" + ss + "丨" + ww + colorfoot;
    return (str);
}

function tick() {
    var today;
    today = new Date();
    document.getElementById("localtime").innerHTML = showLocale(today);
    window.setTimeout("tick()", 1000);
}


/* 天数计算 */
function show_date_time() {
    window.setTimeout("show_date_time()", 1000);
    BirthDay = new Date(startTime);
    today = new Date();
    timeold = (today.getTime() - BirthDay.getTime());
    sectimeold = timeold / 1000
    secondsold = Math.floor(sectimeold);
    msPerDay = 24 * 60 * 60 * 1000
    e_daysold = timeold / msPerDay
    daysold = Math.floor(e_daysold);
    e_hrsold = (e_daysold - daysold) * 24;
    hrsold = Math.floor(e_hrsold);
    e_minsold = (e_hrsold - hrsold) * 60;
    minsold = Math.floor((e_hrsold - hrsold) * 60);
    seconds = Math.floor((e_minsold - minsold) * 60);
    showtime.innerHTML = `The station operates stably for ${daysold} days`;
}


/* 动态标题 */
/* 过于dinner */
function animatetitle() {
    var tx = new Array("欢迎访问<?php echo $GLOBALS['name']; ?>", "本站API接口免费调用", "持续更新……", "等你探索", "谢谢访问", "调用第三方接口需自行承担风险", "站长QQ:<?php echo $GLOBALS['customerService']; ?>");
    var txcount = 4;
    var i = 1;
    var wo = 0;
    var ud = 1;

    window.document.title = tx[wo].substr(0, i) + "";
    if (ud == 0) i--;
    if (ud == 1) i++;
    if (i == -1) {
        ud = 1;
        i = 0;
        wo++;
        wo = wo % txcount;
    }
    if (i == tx[wo].length + 10) {
        ud = 0;
        i = tx[wo].length;
    }
    parent.window.document.title = tx[wo].substr(0, i) + "";
    setTimeout("animatetitle()", 100);
}

function goodMsg(hour, named = '') {
    if (!hour) {
        now = new Date(),
            hour = now.getHours()
    }

    if (hour < 6) {
        return `凌晨好！${named}`;
    } else if (hour < 9) {
        return `早上好！${named}`;
    } else if (hour < 12) {
        return `上午好！${named}`;
    } else if (hour < 14) {
        return `中午好！${named}`;
    } else if (hour < 17) {
        return `下午好！${named}`;
    } else if (hour < 19) {
        return `傍晚好！${named}`;
    } else if (hour < 22) {
        return `晚上好！${named}`;
    } else {
        return `夜深了，注意眼睛哦！${named}`;
    }
}


/* Echarts图表渲染 */
function echartsRender1(domName, dataCategory, dataValue) {
    let chartDom = document.getElementById(domName);
    let myChart = echarts.init(chartDom);
    let option;

    option = {
        xAxis: {
            type: 'category',
            data: dataCategory
        },
        yAxis: {
            type: 'value'
        },
        series: [
            {
                data: dataValue,
                type: 'line',
                smooth: true
            }
        ]
    };
    option && myChart.setOption(option);
}

function echartsRender2(domName, title, subtitle, data) {
    let chartDom = document.getElementById(domName);
    let myChart = echarts.init(chartDom);
    let option;

    option = {
        title: {
            text: title,
            subtext: subtitle,
            left: 'center'
        },
        tooltip: {
            trigger: 'item'
        },
        legend: {
            orient: 'vertical',
            left: 'left'
        },
        series: [
            {
                name: 'Access From',
                type: 'pie',
                radius: '50%',
                data: data,
                emphasis: {
                    itemStyle: {
                        shadowBlur: 10,
                        shadowOffsetX: 0,
                        shadowColor: 'rgba(0, 0, 0, 0.5)'
                    }
                }
            }
        ]
    };
    option && myChart.setOption(option);
}