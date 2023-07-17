<?php
/* 状态码-说明信息  */
return [
    500 => "success",
    501 => "fail:parameter cannot be empty",
    502 => "fail:parameter error",
    503 => "fail:not found",
    507 => "fail:illegal string",
    508 => 'fail:database reject',
    509 => 'fail:bad request',
    510 => 'fail:server reject',
    511 => 'fail:known error',
    /* 功能 */
    611 => 'fail:apikey error or empty or expired',
    612 => 'fail:child site apikey error or empty or expired, please call admin of website',
    // 612 => '子站的APIKEY错误或为空或过期，请联系网站管理员检查是否接入成功！',
    613 => 'fail:unauthorized website',
    614 => 'fail:be not master server'
];
