/*** 
 * @Author: Biyuehu biyuehuya@gmail.com
 * @Blog: http://imlolicon.tk
 * @Date: 2022-12-22 15:57:09
 */

const getQuery = (url) => {
    const str = url.substr(url.indexOf('?') + 1);
    const arr = str.split('&');
    const result = {}
    for (let i = 0; i < arr.length; i++) {
        const item = arr[i].split('=')
        result[item[0]] = item[1]
    }
    return result;
};
const _REQUEST = getQuery(decodeURI(location.href));

title = _REQUEST["title"] ?? "2023兔年快乐";
msg = _REQUEST["msg"] ?? "赵广姚|新年快乐|新的一年里，希望你开心，快乐，健康♥";
music = _REQUEST["music"] ?? '1753961268';

document.title = title;

const bless = msg.split('|');

const blessStyle = {
    color: "#c7f0ff",          	    // 文字颜色
    shadowColor: "#00aeec",   // 文字阴影颜色
    fontSize: "3",   		 // 文字大小
    blod: 1                 		// 文字加粗，1加粗，0不加粗
}

var music = {
    src: "http://music.163.com/song/media/outer/url?id=" + music + ".mp3",  // 音乐地址，不需要音乐，写成""
    loop: 1,		// 音乐循环播放吗？ 1循环播放 0 只播放一遍
    volume: 1,		// 音乐大小，默认为1，范围【0~1】，注意0~1
}