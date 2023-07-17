<?php
/*
 * @Author: Biyuehu biyuehuya@gmail.com
 * @Blog: http://imlolicon.tk
 * @Date: 2023-01-17 13:36:45
 */

namespace Base\Models;

use function Core\Func\loadConfig;

$prefix = loadConfig('database.php')['prefix'];

define('ControllerSetModel', "SELECT * FROM {$prefix}set WHERE set_type = ?");

define('ControllerLogWriteModel', "INSERT INTO {$prefix}log(ua, url, request, ip) VALUES(?, ?, ?, ?)");

define('ControllerGetApiINumModel', "SELECT * FROM {$prefix}api WHERE state = ? ORDER BY id DESC");

define('ControllerVerifyApikeyModel', "SELECT * FROM {$prefix}apikey WHERE api = ? AND apikey = ?");

/* 页面 */
define('PageIndexModel', "SELECT * FROM {$prefix}api ORDER BY id DESC");

define('PageDocModel', "SELECT * FROM {$prefix}api WHERE idstr = ?");
define('PageDocApikeyModel', "SELECT * FROM {$prefix}apikey WHERE account = ? AND api = ?");

define('PageApiCheckModel', "SELECT * FROM {$prefix}apikey WHERE apikey = ? AND api = ?");

define('PageUserIndexModel', "SELECT * FROM {$prefix}apikey WHERE account = ?");

define('PageAdminApieditModel', "SELECT * FROM {$prefix}api WHERE idstr = ?");

define('PageAdminAccounteditModel', "SELECT * FROM {$prefix}account WHERE id = ?");

define('PageAdminWebsafelogModel', "SELECT * FROM {$prefix}log ORDER BY id DESC");

define('PageSiteInfoModel', "SELECT * FROM {$prefix}account WHERE website = ?");

define('PageSiteNumModel', "SELECT * FROM {$prefix}account WHERE website != NULL");


/* 登录 */
define('HandleUserLoginModel', "SELECT * FROM {$prefix}account WHERE email = ? AND password = ?");

/* 站点接入 */
define('HandleUserWebsiteModel', "UPDATE {$prefix}account SET website = ? WHERE id = ?");

/* 个人资料 */
define('HandleUserPersonPasswordModel', "UPDATE {$prefix}account SET password = ? WHERE email = ?");

/* API列表(拥有) */
define('HandleUserApilistModel', "SELECT * FROM {$prefix}apikey WHERE account = ? ORDER BY id DESC");
define('HandleUserApilistResetModel', "UPDATE {$prefix}apikey SET apikey = ? WHERE account = ? AND api = ?");
define('HandleUserApilistContinueModel', "UPDATE {$prefix}apikey SET ctime = ? WHERE account = ? AND api = ?");

/* API商店 */
define('HandleUserApishopBuyCheckModel', "SELECT * FROM {$prefix}apikey WHERE account = ? AND api = ?");
define('HandleUserApishopBuyExecModel', "INSERT INTO {$prefix}apikey(account, api, apikey, ctime) VALUES(?, ?, ?, ?)");
define('HandleUserApishopBuyExec2Model', "UPDATE {$prefix}account SET coin = ? WHERE id = ?");


/* 设置 */
define('HandleAdminWebsetExecModel', "UPDATE {$prefix}set SET set_val = ? WHERE set_key = ? AND set_type = ?");

define('HandleAdminWebsetCheckModel', "SELECT * FROM {$prefix}set WHERE set_key = ? AND set_type = ?");

define('HandleAdminWebsetAddModel', "INSERT INTO {$prefix}set(set_key, set_val, set_type) VALUES(?, ?, ?)");

/* APP添加 */
define('HandleAdminApiaddCheckModel', "SELECT * FROM {$prefix}api WHERE title = ? OR idstr = ?");

define('HandleAdminApiaddExecModel', "INSERT INTO {$prefix}api(title, subtitle, idstr, state, returnTemp, returnType, returnPar, requestTemp, requestType, requestPar, codeTemp, codePar, coin) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 0)");

/* API列表 */
define('HandleAdminApilistDelModel', "DELETE FROM {$prefix}api WHERE idstr = ?");

/* API编辑 */
define('HandleAdminApieditCheckModel', "SELECT * FROM {$prefix}api WHERE title = ? AND id != ?");

define('HandleAdminApieditExecModel', "UPDATE {$prefix}api SET title = ?, subtitle = ?, state = ?, returnTemp = ?, returnType = ?, returnPar = ?, requestTemp = ?, requestType = ?, requestPar = ?, codeTemp = ?, codePar = ?, coin = ? WHERE id = ?");

/* 账户列表 */
define('HandleAdminAccountModel', "SELECT * FROM {$prefix}account");

define('HandleAdminAccountDelModel', "DELETE FROM {$prefix}account WHERE id = ?");

/* 账户添加 */
define('HandleAdminAccountaddCheckModel', "SELECT * FROM {$prefix}account WHERE name = ? OR email = ?");

define('HandleAdminAccountaddExecModel', "INSERT INTO {$prefix}account(name, email, password, opgroup, ip, coin) VALUES(?, ?, ?, ?, ?, ?)");

/* 账户编辑 */
define('HandleAdminAccounteditCheckModel', "SELECT * FROM {$prefix}account WHERE (name = ? OR email = ?) AND id != ?");

define('HandleAdminAccounteditExecModel', "UPDATE {$prefix}account SET name = ?, email = ?, opgroup = ?, coin = ? WHERE id = ?");

