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


msg = _REQUEST["msg"] ?? '胡斐勇|Merry Christmas|健健康康，平安喜乐|一定要站在你所热爱的世界里闪闪发光';
msg = msg.split('|');
music = _REQUEST["music"] ?? '1892513656';
music = "http://music.163.com/song/media/outer/url?id=" + music + ".mp3";
