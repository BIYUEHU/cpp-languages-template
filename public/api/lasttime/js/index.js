/***
 * @Author: Biyuehu biyuehuya@gmail.com
 * @Blog: http://hotaru.icu
 * @Date: 2022-12-22 15:57:09
 */

const _REQUEST = getQuery(decodeURI(location.href));

time = _REQUEST["time"];
_name = _REQUEST["name"];
title = _REQUEST["title"];
descr = _REQUEST["descr"];
message = _REQUEST["message"];

time == null ? (time = "2023-06-13 8:00:00") : time;
_name == null ? (_name = "同学们！") : _name;
title == null ? (title = "2023中考倒计时") : title;
descr == null ? (descr = "距离2023年中考还有") : descr;
message == null
  ? (message =
      "寄语：在奋斗的过程中，常会遭受挫折，惟有坚持到底，才会获得最后的成功！")
  : message;

document.title = title;

const goodMsg = ((hour, named = "") => {
  if (!hour) {
    (now = new Date()), (hour = now.getHours());
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
})(null, _name);

$("#goodMsg").append(goodMsg);
$("#descr").append(descr);
$("#message").append(message);

/**
 * 倒计时函数
 * @param timeStr 时间字符串
 * @param item 模式选择，如果传入'day'，按天数倒计时到秒，不传值，按小时精确到秒
 */
const timer = ((timeStr, item) => {
  setInterval(function () {
    let nowTime = new Date(timeStr) - new Date();
    let minutes = parseInt((nowTime / 1000 / 60) % 60, 10); //计算剩余的分钟
    let seconds = parseInt((nowTime / 1000) % 60, 10); //计算剩余的秒数

    minutes = checkTime(minutes);
    seconds = checkTime(seconds);
    if (item === "day") {
      let days = parseInt(nowTime / 1000 / 60 / 60 / 24, 10); //计算剩余的天数
      let hours = parseInt((nowTime / 1000 / 60 / 60) % 24, 10); //计算剩余的小时
      days = checkTime(days);
      hours = checkTime(hours);
      document.getElementById("timer").innerHTML =
        days + "天" + hours + "小时" + minutes + "分" + seconds + "秒";
    } else {
      let hours = parseInt(nowTime / (1000 * 60 * 60), 10); //计算剩余的小时
      hours = checkTime(hours);
      document.getElementById("timer").innerHTML =
        hours + "小时" + minutes + "分" + seconds + "秒";
    }
  }, 1000);
})(time, "day");

/**
 * 将0-9的数字前面加上0，例1变为01
 * @param i 数字
 * @return i
 */
function checkTime(i) {
  if (i < 10) {
    i = "0" + i;
  }
  return i;
}
