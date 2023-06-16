<?php
error_reporting(0);
$word=$_GET['word'];
$page=$_GET['page'];
$pn=($page-1)*10;

$url='http://tieba.baidu.com/mo/m?word='.$word.'&tn=bdPSW&pn='.$pn.'&sub5=%E6%90%9C%E4%BD%9C%E8%80%85';
$data=get_curl($url);

if(preg_match('/建议您检查输入作者名有无错误/',$data))
{
	exit('<div class="alert alert-warning">未找到"'.$word.'"发布的贴子,用户不存在或动态被隐藏.</div>');
}
preg_match_all('!<div class="i">(.*?)</div>!is',$data,$matchs);
echo '<ul class="list-group">';
foreach($matchs[1] as $list){
	if(preg_match('!<a href.*?kz=(\d+)&amp;sc=(\d+)&amp;.*?">(.*?)</a><br/>(.*?)<br/>.*?<a class="b".*?">(.*?)</a>.*?&#160;<span class="b">(.*?)</span>!is',$list,$match)){
		echo '<li class="list-group-item"><a href="http://tieba.baidu.com/p/'.$match[1].'?pid='.$match[2].'&cid=#'.$match[2].'" target="_blank" title="查看帖子">'.$match[3].'</a><br/>'.$match[4].'<br/><font color="green"><a href="http://tieba.baidu.com/f?kw='.urlencode($match[5]).'" target="_blank" title="进入贴吧" style="color:green;">'.$match[5].'吧</a>&nbsp;'.$match[6].'</font></li>';
	}
	elseif(preg_match('!<a href.*?kz=(\d+)&amp;sc=(\d+)&amp;.*?">(.*?)</a><br/>.*?<a class="b".*?">(.*?)</a>.*?&#160;<span class="b">(.*?)</span>!is',$list,$match)){
		echo '<li class="list-group-item"><a href="http://tieba.baidu.com/p/'.$match[1].'?pid='.$match[2].'&cid=#'.$match[2].'" target="_blank" title="查看帖子">'.$match[3].'</a><br/><font color="green"><a href="http://tieba.baidu.com/f?kw='.urlencode($match[5]).'" target="_blank" title="进入贴吧" style="color:green;">'.$match[5].'吧</a>&nbsp;'.$match[6].'</font></li>';
	}
	else continue;
	//print_r($match);
}
echo '</ul>';

preg_match('!<div class="bc">第(\d+)页/共(\d+)页</div>!i',$data,$match);

$first=1;
$prev=$page-1;
$next=$page+1;
$last=$match[2];
echo'<ul class="pagination">';
if ($page>1)
{
echo '<li><a href="#" onclick="showresult(\''.$word.'\','.$first.')">首页</a></li>';
echo '<li><a href="#" onclick="showresult(\''.$word.'\','.$prev.')">&laquo;</a></li>';
} else {
echo '<li class="disabled"><a>首页</a></li>';
echo '<li class="disabled"><a>&laquo;</a></li>';
}
for ($i=1;$i<$page;$i++)
echo '<li><a href="#" onclick="showresult(\''.$word.'\','.$i.')">'.$i .'</a></li>';
echo '<li class="disabled"><a>'.$page.'</a></li>';
for ($i=$page+1;$i<=($last>=10?$page+9:$last);$i++)
echo '<li><a href="#" onclick="showresult(\''.$word.'\','.$i.')">'.$i .'</a></li>';
if ($page<$last)
{
echo '<li><a href="#" onclick="showresult(\''.$word.'\','.$next.')">&raquo;</a></li>';
echo '<li><a href="#" onclick="showresult(\''.$word.'\','.$last.')">尾页</a></li>';
} else {
echo '<li class="disabled"><a>&raquo;</a></li>';
echo '<li class="disabled"><a>尾页</a></li>';
}
echo'</ul>';

function get_curl($url, $post=0, $referer=0, $cookie=0, $header=0, $ua=0, $nobaody=0)
{
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	$httpheader[] = "Accept:*/*";
	$httpheader[] = "Accept-Encoding:gzip,deflate,sdch";
	$httpheader[] = "Accept-Language:zh-CN,zh;q=0.8";
	$httpheader[] = "Connection:close";
	curl_setopt($ch, CURLOPT_HTTPHEADER, $httpheader);
	if ($post) {
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
	}
	if ($header) {
		curl_setopt($ch, CURLOPT_HEADER, true);
	}
	if ($cookie) {
		curl_setopt($ch, CURLOPT_COOKIE, $cookie);
	}
	if($referer){
		if($referer==1){
			curl_setopt($ch, CURLOPT_REFERER, 'http://tieba.baidu.com/');
		}else{
			curl_setopt($ch, CURLOPT_REFERER, $referer);
		}
	}
	if ($ua) {
		curl_setopt($ch, CURLOPT_USERAGENT, $ua);
	}
	else {
		curl_setopt($ch, CURLOPT_USERAGENT, "MQQBrowser/Mini3.1 (Nokia3050/MIDP2.0)");
	}
	if ($nobaody) {
		curl_setopt($ch, CURLOPT_NOBODY, 1);
	}
	curl_setopt($ch, CURLOPT_ENCODING, "gzip");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$ret = curl_exec($ch);
	curl_close($ch);
	return $ret;
}