-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- 主机： localhost
-- 生成日期： 2023-07-15 11:53:28
-- 服务器版本： 5.6.50-log
-- PHP 版本： 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";

START TRANSACTION;

SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */
;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */
;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */
;
/*!40101 SET NAMES utf8mb4 */
;

--
-- 数据库： `apidatabase`
--

-- --------------------------------------------------------

--
-- 表的结构 `huliapi_account`
--

CREATE TABLE `huliapi_account` (
    `id` int(6) UNSIGNED NOT NULL,
    `name` varchar(10) NOT NULL,
    `email` varchar(50) NOT NULL,
    `password` varchar(30) NOT NULL,
    `opgroup` int(1) NOT NULL DEFAULT '1',
    `ip` varchar(40) DEFAULT NULL,
    `coin` int(11) NOT NULL DEFAULT '0',
    `reg_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE = InnoDB DEFAULT CHARSET = utf8;

--
-- 转存表中的数据 `huliapi_account`
--

INSERT INTO
    `huliapi_account` (
        `id`,
        `name`,
        `email`,
        `password`,
        `opgroup`,
        `ip`,
        `coin`,
        `reg_date`
    )
VALUES (
        1,
        'admin',
        'admin@qq.com',
        '123456',
        4,
        '',
        2333,
        '2022-09-20 02:36:36'
    );

-- --------------------------------------------------------

--
-- 表的结构 `huliapi_api`
--

CREATE TABLE `huliapi_api` (
    `id` int(6) UNSIGNED NOT NULL,
    `title` varchar(100) NOT NULL,
    `subtitle` varchar(100) NOT NULL,
    `idstr` varchar(100) NOT NULL,
    `state` int(11) NOT NULL,
    `returnTemp` text,
    `returnType` text,
    `returnPar` text,
    `requestTemp` text,
    `requestType` text,
    `requestPar` text,
    `codeTemp` text,
    `codePar` text,
    `coin` int(11) NOT NULL,
    `reg_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;

--
-- 转存表中的数据 `huliapi_api`
--

INSERT INTO
    `huliapi_api` (
        `id`,
        `title`,
        `subtitle`,
        `idstr`,
        `state`,
        `returnTemp`,
        `returnType`,
        `returnPar`,
        `requestTemp`,
        `requestType`,
        `requestPar`,
        `codeTemp`,
        `codePar`,
        `coin`,
        `reg_date`
    )
VALUES (
        1,
        '[核心CORE]统计API',
        'HULICORE ByHotaru',
        'stat',
        3,
        '{\n	\"code\": 500,\n	\"message\": \"success\",\n	\"data\": 865\n}',
        'application/json',
        'data&string&返回数据',
        '?op=queryday&name=api_call_inside&par2=2',
        'GET/POST',
        'name&是&string&选择器名字|op&是&string&操作,选填query,queryday,write,add|par2&否&string&进行queryday操作时,可指定多少天前的数据,默认0',
        NULL,
        '500&请求成功|501&选择器已存在|502&选择器不存在|503&参数错误|504&未知的错误',
        0,
        '2022-12-19 14:00:32'
    ),
    (
        2,
        'UUID获取',
        '随机获取UUID',
        'uuidget',
        1,
        '{\n    \"code\": 500,\n    \"message\": \"success\",\n    \"data\": [\n        \"e93ff75f-06bf-ef6d-406b-64d1278a209e\",\n        \"c871845a-b41f-032e-afdd-3259890f4d76\",\n        \"5e31eb6b-b882-7d87-fd98-417ef645d829\"\n    ]\n}',
        'application/json',
        'data&array&获取到的数据',
        '?num=3',
        'GET/POST',
        'num&是&number&生成个数,默认1',
        '',
        '',
        0,
        '2022-10-03 08:09:02'
    ),
    (
        3,
        '农历',
        '农历',
        'lunar',
        1,
        '今天是公元2023年01月14日\n农历壬寅年 腊月廿三 虎年\n节气：小寒后',
        'text/plain',
        '',
        '',
        'GET',
        '',
        '',
        '',
        0,
        '2022-10-03 08:09:02'
    );

-- --------------------------------------------------------

--
-- 表的结构 `huliapi_apikey`
--

CREATE TABLE `huliapi_apikey` (
    `id` int(11) UNSIGNED NOT NULL,
    `account` int(11) DEFAULT NULL,
    `api` varchar(255) DEFAULT NULL,
    `apikey` varchar(255) DEFAULT NULL,
    `ctime` timestamp NULL DEFAULT NULL,
    `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;

-- --------------------------------------------------------

--
-- 表的结构 `huliapi_lib_stat`
--

CREATE TABLE `huliapi_lib_stat` (
    `id` int(11) UNSIGNED NOT NULL,
    `sign` varchar(255) DEFAULT NULL,
    `result` int(11) DEFAULT NULL,
    `type_` varchar(255) DEFAULT NULL
) ENGINE = MyISAM DEFAULT CHARSET = utf8;

--
-- 转存表中的数据 `huliapi_lib_stat`
--

INSERT INTO
    `huliapi_lib_stat` (
        `id`,
        `sign`,
        `result`,
        `type_`
    )
VALUES (
        13,
        'uuidget_inside',
        0,
        'total'
    ),
    (
        15,
        'lunar_inside',
        0,
        'total'
    ),
    (75, 'stat_inside', 0, 'total'),
    (
        105,
        'api_call_inside',
        0,
        'total'
    ),
    (
        115,
        'web_visitor_inside',
        0,
        'total'
    ),
    (
        120,
        'web_visit_inside',
        0,
        'total'
    );
-- --------------------------------------------------------

--
-- 表的结构 `huliapi_log`
--

CREATE TABLE `huliapi_log` (
    `id` int(11) UNSIGNED NOT NULL,
    `ua` varchar(255) DEFAULT NULL,
    `url` varchar(255) DEFAULT NULL,
    `request` varchar(10) DEFAULT NULL,
    `ip` varchar(16) DEFAULT NULL,
    `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;

--
-- 转存表中的数据 `huliapi_log`
--

INSERT INTO
    `huliapi_log` (
        `id`,
        `ua`,
        `url`,
        `request`,
        `ip`,
        `date`
    )
VALUES (
        1,
        '...',
        'localhost',
        'get',
        '127.0.0.1',
        '2023-07-15 03:53:12'
    );

-- --------------------------------------------------------

--
-- 表的结构 `huliapi_set`
--

CREATE TABLE `huliapi_set` (
    `id` int(6) UNSIGNED NOT NULL,
    `set_key` varchar(100) NOT NULL,
    `set_val` text,
    `set_type` varchar(100) DEFAULT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;

--
-- 转存表中的数据 `huliapi_set`
--

INSERT INTO
    `huliapi_set` (
        `id`,
        `set_key`,
        `set_val`,
        `set_type`
    )
VALUES (
        1,
        'weburl',
        'https://api.hotaru.icu',
        'webinfo'
    ),
    (
        2,
        'webtitle',
        'HULIAPI',
        'webinfo'
    ),
    (
        3,
        'websubtitle',
        '接口站点',
        'webinfo'
    ),
    (
        4,
        'webdescr',
        '提供高效、快速、稳定的API接口',
        'webinfo'
    ),
    (
        5,
        'keywords',
        '聚合数据,API数据接口,API',
        'webinfo'
    ),
    (
        6,
        'author',
        'Himeno',
        'webinfo'
    ),
    (
        7,
        'email',
        'admin@qq.com',
        'webinfo'
    ),
    (
        8,
        'createTime',
        '2021-6-19',
        'webinfo'
    ),
    (
        9,
        'theme',
        'default',
        'webinfo'
    ),
    (
        43,
        'mainColor',
        'pink',
        'theme_default'
    ),
    (
        44,
        'headUrl',
        'Links,/friends|Blog,http://hotaru.icu,1',
        'theme_default'
    ),
    (
        45,
        'tips',
        'Full use of https!',
        'theme_default'
    ),
    (
        46,
        'openEjct',
        '<strong>HULICore(接口管理核心系统)</strong>已开源至<a href=\"https://github.com/BIYUEHU/hulicore\" target=\"_blank\">Github-></a>，快去给糊狸点个star吧~',
        'theme_default'
    ),
    (
        47,
        'openRoll',
        '滚动公告',
        'theme_default'
    ),
    (
        48,
        'advert',
        '',
        'theme_default'
    ),
    (
        49,
        'bottom1',
        '<div style=\"color:lightgreen\">网站描述</div>',
        'theme_default'
    ),
    (
        50,
        'bottom2',
        '<div style=\"color:red\">网站描述</div>',
        'theme_default'
    ),
    (
        51,
        'codeHead',
        '',
        'theme_default'
    ),
    (
        52,
        'codeFoot',
        '',
        'theme_default'
    ),
    (
        53,
        'friends',
        'http://hotaru.icu,HotaruBlog,糊狸的小破站,https://hotaru.icu/favicon.ico|https://tool.hotaru.icu,糊狸工具箱,https://biyuehu.github.io/ico/png/tool.png',
        'theme_default'
    ),
    (
        54,
        'host',
        'smtp.qq.com',
        'plugins_email'
    ),
    (
        55,
        'port',
        '465',
        'plugins_email'
    ),
    (
        56,
        'username',
        '',
        'plugins_email'
    ),
    (
        57,
        'password',
        '',
        'plugins_email'
    ),
    (
        58,
        'fromuser',
        '',
        'plugins_email'
    ),
    (
        60,
        'fromname',
        'FoxHelperOne',
        'plugins_email'
    ),
    (
        61,
        'crossdomain',
        'on',
        'websafe'
    ),
    (62, 'cycle', '60', 'websafe'),
    (
        63,
        'cyclenum',
        '17',
        'websafe'
    ),
    (
        64,
        'refusemsg',
        '调用过于频繁请稍后再试',
        'websafe'
    ),
    (
        65,
        'badapimsg',
        '该接口正在维护中',
        'websafe'
    ),
    (
        66,
        'safeimport',
        'nagisa',
        'websafe'
    ),
    (
        67,
        'accentColor',
        'purple',
        'theme_default'
    ),
    (
        68,
        'log',
        '还没有更新日志',
        'webinfo'
    ),
    (
        69,
        'useropen',
        '用户中心公告',
        'webinfo'
    ),
    (
        70,
        'startcoin',
        '50',
        'webinfo'
    );

--
-- 转储表的索引
--

--
-- 表的索引 `huliapi_account`
--
ALTER TABLE `huliapi_account`
ADD PRIMARY KEY (`id`),
ADD UNIQUE KEY `adminname` (`name`, `email`);

--
-- 表的索引 `huliapi_api`
--
ALTER TABLE `huliapi_api`
ADD PRIMARY KEY (`id`),
ADD UNIQUE KEY `title` (`title`, `idstr`);

--
-- 表的索引 `huliapi_apikey`
--
ALTER TABLE `huliapi_apikey` ADD PRIMARY KEY (`id`);

--
-- 表的索引 `huliapi_lib_stat`
--
ALTER TABLE `huliapi_lib_stat` ADD PRIMARY KEY (`id`);

--
-- 表的索引 `huliapi_log`
--
ALTER TABLE `huliapi_log` ADD PRIMARY KEY (`id`);

--
-- 表的索引 `huliapi_set`
--
ALTER TABLE `huliapi_set` ADD PRIMARY KEY (`id`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `huliapi_account`
--
ALTER TABLE `huliapi_account`
MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT,
AUTO_INCREMENT = 10;

--
-- 使用表AUTO_INCREMENT `huliapi_api`
--
ALTER TABLE `huliapi_api`
MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT,
AUTO_INCREMENT = 99;

--
-- 使用表AUTO_INCREMENT `huliapi_apikey`
--
ALTER TABLE `huliapi_apikey`
MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
AUTO_INCREMENT = 14;

--
-- 使用表AUTO_INCREMENT `huliapi_lib_stat`
--
ALTER TABLE `huliapi_lib_stat`
MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
AUTO_INCREMENT = 945;

--
-- 使用表AUTO_INCREMENT `huliapi_log`
--
ALTER TABLE `huliapi_log`
MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
AUTO_INCREMENT = 2;

--
-- 使用表AUTO_INCREMENT `huliapi_set`
--
ALTER TABLE `huliapi_set`
MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT,
AUTO_INCREMENT = 71;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */
;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */
;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */
;