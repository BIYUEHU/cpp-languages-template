const _REQUEST = getQuery(decodeURI(location.href));

msg = _REQUEST["msg"] ?? '胡斐勇|Merry Christmas|健健康康，平安喜乐|一定要站在你所热爱的世界里闪闪发光';
msg = msg.split('|');
music = _REQUEST["music"] ?? '1892513656';
music = "http://music.163.com/song/media/outer/url?id=" + music + ".mp3";
