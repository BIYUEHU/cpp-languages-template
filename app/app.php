<?php
/*
 * @Author: Biyuehu biyuehuya@gmail.com
 * @Blog: http://imlolicon.tk
 * @Date: 2023-01-17 13:48:12
 */


/* 页面 */
/* 主页相关 */
Route::any('/', 'IndexController@index');

Route::get('/log', 'IndexController@log');

Route::get('/friends', 'IndexController@friends');

Route::get('/jumpto', 'IndexController@jumpto');

Route::get('/about', 'IndexController@about');

/* 文档入口 */
Route::get(APP_DOC_PATH . '/{val}', 'IndexController@doc');

/* 接口映射入口 */
Route::any(APP_API_PATH . '/{val}', 'IndexController@api');

/* 文章(自定义页面)入口 */
Route::any('/article/{val}', 'IndexController@article');

/* 静态资源映射入口 */
Route::get('/assets/{val}}', 'IndexController@assets');


/* User */
/* 登录 */
Route::get(APP_USER_PATH . '/login', 'User/IndexController@login');

Route::any(APP_USER_PATH . '/loginout', 'User/IndexController@loginout');

/* 仪表盘 */
Route::get(APP_USER_PATH . '/', 'User/IndexController@index');

/* 接口列表(拥有) */
Route::get(APP_USER_PATH . '/apilist', 'User/IndexController@apilist');

/* 接口商店 */
Route::get(APP_USER_PATH . '/apishop', 'User/IndexController@apishop');

/* 金额充值 */
Route::get(APP_USER_PATH . '/coinpay', 'User/IndexController@coinpay');

/* 个人资料 */
Route::get(APP_USER_PATH . '/person', 'User/IndexController@person');


/* Admin */
/* 仪表盘 */
Route::get(APP_ADMIN_PATH . '/', 'Admin/IndexController@index');

/* 网站设置 */
Route::get(APP_ADMIN_PATH . '/webset', 'Admin/IndexController@webset');

/* 接口三套 */
Route::get(APP_ADMIN_PATH . '/apiadd', 'Admin/IndexController@apiadd');

Route::get(APP_ADMIN_PATH . '/apilist', 'Admin/IndexController@apilist');

Route::get(APP_ADMIN_PATH . '/apiedit', 'Admin/IndexController@apiedit');

/* 账户三套 */
Route::get(APP_ADMIN_PATH . '/account', 'Admin/IndexController@account');

Route::get(APP_ADMIN_PATH . '/accountadd', 'Admin/IndexController@accountadd');

Route::get(APP_ADMIN_PATH . '/accountedit', 'Admin/IndexController@accountedit');

/* 网站安全 */
Route::get(APP_ADMIN_PATH . '/websafe', 'Admin/IndexController@websafe');

/* 主题设置 */
Route::get(APP_ADMIN_PATH . '/themes', 'Admin/IndexController@themes');

/* 插件设置 */
Route::get(APP_ADMIN_PATH . '/plugins', 'Admin/IndexController@plugins');

Route::get(APP_ADMIN_PATH . '/fileupload', 'Admin/IndexController@fileupload');


/* API */
/* 登录 */
Route::post(APP_USER_PATH . '/login', 'User/HandleController@login');
// Route::post(APP_ADMIN_PATH . '/login/{val}', 'Admin/HandleController@login');

/* 接口列表(拥有) */
Route::post(APP_USER_PATH . '/apilist', 'User/HandleController@apilist');
Route::post(APP_USER_PATH . '/apilistreset', 'User/HandleController@apilistreset');
Route::post(APP_USER_PATH . '/apilistcontinue', 'User/HandleController@apilistcontinue');

/* 接口商店 */
Route::post(APP_USER_PATH . '/apishop', 'User/HandleController@apishop');
Route::post(APP_USER_PATH . '/apishopbuy', 'User/HandleController@apishopbuy');

/* 个人资料 */
Route::post(APP_USER_PATH . '/person', 'User/HandleController@person');
Route::post(APP_USER_PATH . '/personupload', 'User/HandleController@personupload');

/* 网站设置 */
Route::post(APP_ADMIN_PATH . '/webset', 'Admin/HandleController@webset');

/* 接口四套 */
Route::post(APP_ADMIN_PATH . '/apiadd', 'Admin/HandleController@apiadd');

Route::post(APP_ADMIN_PATH . '/apilist', 'Admin/HandleController@apilist');

Route::post(APP_ADMIN_PATH . '/apilistdel', 'Admin/HandleController@apilistdel');

Route::post(APP_ADMIN_PATH . '/apiedit', 'Admin/HandleController@apiedit');

/* 账户四套 */
Route::post(APP_ADMIN_PATH . '/account', 'Admin/HandleController@account');

Route::post(APP_ADMIN_PATH . '/accountdel', 'Admin/HandleController@accountdel');

Route::post(APP_ADMIN_PATH . '/accountadd', 'Admin/HandleController@accountadd');

Route::post(APP_ADMIN_PATH . '/accountedit', 'Admin/HandleController@accountedit');

/* 网站安全 */
Route::post(APP_ADMIN_PATH . '/websafe', 'Admin/HandleController@websafe');

Route::post(APP_ADMIN_PATH . '/websafelog', 'Admin/HandleController@websafelog');

/* 主题设置 */
Route::post(APP_ADMIN_PATH . '/themes', 'Admin/HandleController@themes', false);

/* 插件设置 */
Route::post(APP_ADMIN_PATH . '/plugins', 'Admin/HandleController@plugins');

Route::post(APP_ADMIN_PATH . '/pluginssendemail', 'Admin/HandleController@pluginssendemail', false);



/* 系统级API */
Route::any('/sys/getthemeicon', 'Sys/IndexController@getthemeicon');

Route::any('/sys/getaccountavatar', 'Sys/IndexController@getaccountavatar');

Route::any('/sys/captchaimg', 'Sys/IndexController@captchaimg');

Route::any('/sys/datastat', 'Sys/IndexController@datastat');




/* Test */
// Route::get('/init', 'IndexController@init');

Route::any('/demo', function () {
    // echo 'hello huli!';
});


/* 扩展Other */
Route::get(APP_ADMIN_PATH . '/other', 'Other/IndexController@index');

Route::post(APP_ADMIN_PATH . '/other/{val}', 'Other/HandleController@index');

/* 404错误页渲染 */
Route::error(404, 'IndexController@error404');
