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

_name = _REQUEST["name"];
descr = _REQUEST["descr"];
img = _REQUEST["img"];
ua = _REQUEST["ua"];
url = _REQUEST["url"];

_name == null ? _name = '糊狸' : null;
descr == null ? descr = '这是一只可爱的糊狸' : null;
img == null ? img = 'https://biyuehu.github.io/images/avatar.png' : null;
ua == null ? ua = '狐的博客' : null;
url == null ? url = 'http://imlolicon.tk' : null;

document.title = `${_name}个人主页`;
$("#_name").append(_name);
$("#descr").append(descr);
$("img").attr("src", img);
$("#img").attr("src", img);
$("#ua").append(ua);
$("#url").attr("href", url);