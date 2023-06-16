<?php

// use HuliLib\Stat;


header('content-type:application/json');

$tagName = trim($_REQUEST['name']);
$op = trim($_REQUEST['op']);
$par2 = trim($_REQUEST['par2']);

/* 来自核心库:stat.class.php */
$StatDemo = new Stat();

switch ($op) {
    case 'query':
        $StatDemo::QueryTag($tagName);
        break;
    case 'queryday':
        $par2 = empty($par2) ? 0 : intval($par2);
        $StatDemo::QueryDayTag($tagName, $par2);
        break;
    case 'write':
        $StatDemo::WriteTag($tagName);
        break;
    case 'add':
        $StatDemo::AddTag($tagName);
        break;
    default:
        $StatDemo::$errorCode = 504;
}
$result = $StatDemo->Result();

echo stripslashes(urldecode(json_encode($result, 256)));
