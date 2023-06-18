const _REQUEST = getQuery(decodeURI(location.href));

_name = _REQUEST['name'];
version = _REQUEST['version'];
descr = _REQUEST['descr'];
update = _REQUEST['update'];
log = _REQUEST['log'];
size = _REQUEST['size'];
url = _REQUEST['url'];
img = _REQUEST['img'];
img1 = _REQUEST['img1'];

_name == null ? _name = '我的世界最强外挂2.0' : null;
version == null ? version = '2.0.0' : null;
descr == null ? descr = '最牛逼的外挂' : null;
size == null ? size = '5.65M' : null;
update == null ? update = '2.0.0更新' : null;
log == null ? log = '结束了罪恶的一生' : null;
img == null ? img = 'https://biyuehu.github.io/addon/ulang.png' : null;
img1 == null ? img1 = './img/a.gif' : null;
url == null ? url = '/res/我的世界最强外挂2.0.apk' : null;

document.title = `${_name} - APP下载页`;
$("#_name").append(_name);
$("#version").append(version);
$("#descr").append(descr);
$("#size").append(size);
$("#update").append(update);
$("#log").append(log);
$("#img").attr("src", img);
$("#img1").attr("src", img1);
$("#url").attr("href", url);