<?php
$ini = array(
    'keywords' => 'PHP文件在线加密,php网络,PHP免费加密,PHP源码加密,PHP加密,PHP在线加密,PHP代码加密,PHP文件加密',
    'description' => 'php加密是一个优秀的免费的PHP源码加密保护平台，PHP代码加密后无需依靠附加扩展来解析，服务器端无需安装任何第三方组件，可运行于任何普通 PHP 环境下。 虽然加密的强度较高，但会在运行时会占用一定的内存资源，我们只推荐加密class或function主要核心引用文件(不推荐所有文件都加密)。',
);

function encode($code)
{
    $code = str_replace(array('<?php', '?>', '<?PHP'), array('', '', ''), $code);
    $encode = base64_encode(gzdeflate($code));
    $encode = '<?php
        /*
        加密成功
        希望大家不要破解.
        */' . "\neval(gzinflate(base64_decode(" . "'" . $encode . "'" . ")));\n?>";
    return $encode;
}

function decode($code)
{
    $maxTimes = 1000; //最大循环解密次数
    $matches = [];
    $decode = '';
    for ($i = 0; $i < $maxTimes; $i++) {
        $arr = preg_split('/\r\n|\r|\n/', $code);
        $match = false;
        foreach ($arr as $s) {
            if (preg_match('/eval\((gzinflate\(base64_decode\([\'\"]([\w\/=+]+)[\'\"]\)\))\)/', $s, $matches)) {
                ob_start();
                eval('echo ' . $matches[1] . ';');
                $decode = '<?php
' . trim(ob_get_clean()) . '
?>';
                $match = true;
                break;
            }
        }
        if (!$match) {
            break;
        }
    }
    return $decode;
}
