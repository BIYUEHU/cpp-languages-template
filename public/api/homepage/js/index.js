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