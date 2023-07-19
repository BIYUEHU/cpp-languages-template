<?php

namespace Base\Controllers\Admin;

use Base\Controllers\Controller;
use Lib\Stat;
use function Base\Controllers\handleParStr;
use function Core\Func\loadConfig;

class HandleController extends Controller
{

    /* 网站设置 */
    public function webset()
    {
        self::$data['VERIFY']['opgroup'] == 4 || self::printResult(509);

        $rowCount = 0;
        // 遍历传过来的所有参数
        foreach ($_POST as $key => $val) {
            // 判断参数的键是否存在于数据库(设置是否真实存在)
            $rowCount = $rowCount + self::$db->exec(HandleAdminWebsetExecModel, [$val, $key, 'webinfo']);
            // 判断theme(主题)设置是否改变
            if ($key == 'theme' && $val != self::$data['WEB_INFO']['theme']) {
                // 载入改变后的主题对应配置文件
                // 并校验配置文件返回的数据是否正确(是否为数组数据)
                $sets = loadConfig('_config.php', HULICORE_USR_PATH . '/theme/' . $val);
                if (gettype($sets) == 'array') {
                    // 开始遍历配置的所有数据(键值对)
                    foreach ($sets as $set_key => $set_val) {
                        // 判断该设置(数据)是否存在于数据库 否则添加该设置到数据库
                        if (self::$db->exec(HandleAdminWebsetCheckModel, [$set_key, 'theme_' . $val]) < 1) {
                            self::$db->exec(HandleAdminWebsetAddModel, [$set_key, $set_val, 'theme_' . $val]);
                        }
                    }
                }
            }
        }
        self::printResult();
    }


    /* 接口四套 */
    public function apiadd()
    {
        self::$data['VERIFY']['opgroup'] == 4 || self::printResult(509);

        // 四个关键参数不可为空
        $title = $_POST['title'];
        $subtitle = $_POST['subtitle'];
        $idstr = $_POST['idstr'];
        $state = $_POST['state'];
        !empty($title) && !empty($subtitle) && !empty($idstr) && !empty($state) || self::printResult(501);

        $rows = self::$db->fetchAll(HandleAdminApiaddCheckModel, [$title, $idstr]);
        count($rows) < 1 || self::printResult(508);

        // 添加至数据库
        $rowCount = self::$db->exec(HandleAdminApiaddExecModel, [
            $title, $subtitle, $idstr, $state,
            $_POST['returnTemp'], $_POST['returnType'], $_POST['returnPar'],
            $_POST['requestTemp'], $_POST['requestType'], $_POST['requestPar'],
            $_POST['codeTemp'], $_POST['codePar']
        ]);

        // 添加成功则添加该接口的统计数据(Stat)
        if ($rowCount > 0) {
            Stat::AddTag($idstr . '_' . Stat::StatName);
            self::printResult();
        }

        self::printResult(502);
    }

    public function apilist()
    {
        self::$data['VERIFY']['opgroup'] == 4 || self::printResult(509);

        // 页数和数量
        $page = $_POST['page'] ?? 1;
        $limit = $_POST['limit'] ?? 20;
        $limit >= 1 && $limit <= 35 || self::printResult(502);

        $rows = self::$db->fetchAll(PageIndexModel);
        $data = [];
        $count = 0;

        // 遍历获取到的所有数据
        foreach ($rows as $key => $val) {
            $count++;
            // 根据页数和数量填充相应部分数据到新数组内
            if ((($page - 1) * $limit) <= $key && $key < ($page * $limit)) {
                array_push($data, array(
                    'id' => $val['id'],
                    'title' => $val['title'],
                    'subtitle' => $val['subtitle'],
                    'idstr' => $val['idstr'],
                    'state' => intval($val['state']),
                    'returnTemp' => $val['returnTemp'],
                    'returnType' => $val['returnType'],
                    'returnPar' => handleParStr($val['returnPar']),
                    'requestTemp' => $val['requestTemp'],
                    'requestType' => $val['requestType'],
                    'requestPar' => handleParStr($val['requestPar']),
                    'codeTemp' => $val['codeTemp'],
                    'codePar' => handleParStr($val['codePar']),
                    'coin' => intvaL($val['coin']),
                    'reg_date' => $val['reg_date']
                ));
            }
        }

        self::printResult(500, [$count, $data]);
    }

    public function apilistdel()
    {
        self::$data['VERIFY']['opgroup'] == 4 || self::printResult(509);
        $idstr = $_POST['idstr'];
        !empty($idstr) || self::printResult(501);

        // 管他接口是否真的存在先删个Stat统计数据试试
        Stat::DelTag($idstr . '_' . Stat::StatName);
        // 删除数据库里的相应数据并判断是否成功
        $rowCount = self::$db->exec(HandleAdminApilistDelModel, [$idstr]);
        $rowCount < 1 ? self::printResult(502) : self::printResult();
    }

    public function apiedit()
    {
        self::$data['VERIFY']['opgroup'] == 4 || self::printResult(509);

        // 三个关键值不可为空
        $id = $_POST['id'];
        $title = $_POST['title'];
        $subtitle = $_POST['subtitle'];
        !empty($id) && !empty($title) && !empty($subtitle) || self::printResult(501);

        // 判断接口是否存在于数据库
        $rows = self::$db->fetchAll(HandleAdminApieditCheckModel, [$title, $id]);
        count($rows) < 1 || self::printResult(508);

        // 判断coin大小
        $_POST['coin'] >= 0 || self::printResult(502);

        // 根据传入的id获取其接口数据
        $rowCount = self::$db->exec(HandleAdminApieditExecModel, [
            $title, $subtitle, $_POST['state'],
            $_POST['returnTemp'], $_POST['returnType'], $_POST['returnPar'],
            $_POST['requestTemp'], $_POST['requestType'], $_POST['requestPar'],
            $_POST['codeTemp'], $_POST['codePar'], $_POST['coin'], $id
        ]);
        $rowCount === null ? self::printResult(502, $rowCount) : self::printResult();
    }


    // 不注释了跟上面的一样
    /* 账户四套 */
    public function account()
    {
        self::$data['VERIFY']['opgroup'] == 4 || self::printResult(509);

        $page = $_POST['page'] ?? 1;
        $limit = $_POST['limit'] ?? 20;
        $limit >= 1 && $limit <= 35 || self::printResult(502);

        $rows = self::$db->fetchAll(HandleAdminAccountModel);
        $data = [];
        $count = 0;

        foreach ($rows as $key => $val) {
            $count++;
            if ((($page - 1) * $limit) <= $key && $key < ($page * $limit)) {
                $arr = array(
                    'id' => $val['id'],
                    'name' => $val['name'],
                    'email' => $val['email'],
                    'opgroup' => intval($val['opgroup']),
                    'ip' => $val['ip'],
                    'coin' => intval($val['coin']),
                    'reg_date' => $val['reg_date']
                );
                $arr = file_exists(HULICORE_BASE_CONTROLLER_PATH . '/Site/IndexController.php') ? array_merge($arr, [
                    'website' => $val['website'],
                    'nums' => count(self::$db->fetchAll(PageUserIndexModel, [$val['id']])),
                    'call' => intval(Stat::QueryTag('user_' . $val['id'] . ':total')),
                ]) : $arr;
                array_push($data, $arr);
            }
        }

        self::printResult(500, [$count, $data]);
    }

    public function accountdel()
    {
        self::$data['VERIFY']['opgroup'] == 4 || self::printResult(509);
        $id = $_POST['id'];
        !empty($id) || self::printResult(501);

        $rowCount = self::$db->exec(HandleAdminAccountDelModel, [$id]);
        $rowCount < 1 ? self::printResult(502) : self::printResult();
    }

    public function accountadd()
    {
        self::$data['VERIFY']['opgroup'] == 4 || self::printResult(509);
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        !empty($name) && !empty($email) && !empty($password) || self::printResult(501);

        preg_match_all('/(.*?)@(.*)/', $email, $match);
        !empty($match[1]) || self::printResult(502);

        $rows = self::$db->fetchAll(HandleAdminAccountaddCheckModel, [$name, $email]);
        count($rows) < 1 || self::printResult(508);

        $rowCount = self::$db->exec(HandleAdminAccountaddExecModel, [
            $name, $email, $password, intval($_POST['opgroup']),
            $_POST['ip'], $_POST['coin']
        ]);
        $rowCount > 0 ? self::printResult() : self::printResult(502);
    }

    public function accountedit()
    {
        self::$data['VERIFY']['opgroup'] == 4 || self::printResult(509);
        $id = $_POST['id'];
        $name = $_POST['name'];
        $email = $_POST['email'];
        !empty($id) && !empty($name) && !empty($email) || self::printResult(501);

        preg_match_all('/(.*?)@(.*)/', $email, $match);
        !empty($match[1]) || self::printResult(502);

        $rows = self::$db->fetchAll(HandleAdminAccounteditCheckModel, [$name, $email, $id]);
        count($rows) < 1 || self::printResult(508);

        $rowCount = self::$db->exec(HandleAdminAccounteditExecModel, [
            $name, $email, intval($_POST['opgroup']), $_POST['coin'], $id
        ]);
        $rowCount === null ? self::printResult(502, $rowCount) : self::printResult();
    }


    /* 网站安全 */
    public function websafe()
    {
        self::$data['VERIFY']['opgroup'] == 4 || self::printResult(509);

        $rowCount = 0;
        foreach ($_POST as $key => $val) {
            $rowCount = $rowCount + self::$db->exec(HandleAdminWebsetExecModel, [$val, $key, 'websafe']);
        }
        self::printResult();
    }

    public function websafelog()
    {
        self::$data['VERIFY']['opgroup'] == 4 || self::printResult(509);
        $page = $_POST['page'] ?? 1;
        $limit = $_POST['limit'] ?? 20;

        $limit >= 1 && $limit <= 35 || self::printResult(502);

        $rows = self::$db->fetchAll(PageAdminWebsafelogModel);
        $data = [];
        $count = 0;

        foreach ($rows as $key => $val) {
            $count++;
            if ((($page - 1) * $limit) <= $key && $key < ($page * $limit)) {
                array_push($data, array(
                    'ua' => $val['ua'],
                    'url' => $val['url'],
                    'request' => $val['request'],
                    'ip' => $val['ip'],
                    'date' => $val['date']
                ));
            }
        }

        self::printResult(500, [$count, $data]);
    }


    public function personupload()
    {
        self::$data['VERIFY']['opgroup'] >= 3 || self::printResult(509);

        $file = $_FILES['file'];
        $type = $file['type'];
        $size = $file['size'];

        (($type == 'image/png' || $type == 'image/jpeg') && $size <= 1024 * 1024) || self::printResult(510, [$size, $type, $_FILES]);

        $newPath = HULICORE_DATA_PATH . '/account/' . self::$data['VERIFY']['id'] . '.png'; //新路径
        $isok = move_uploaded_file($file['tmp_name'], $newPath);
        $code = $isok ? 500 : 511;
        self::printResult($code, [$size, $type, $_FILES, $newPath, $isok]);
    }


    /* 主题设置 */
    public function themes()
    {
        self::$data['VERIFY']['opgroup'] == 4 || self::printResult(509);

        $rowCount = 0;
        foreach ($_POST as $key => $val) {
            $rowCount = $rowCount + self::$db->exec(HandleAdminWebsetExecModel, [$val, $key, 'theme_' . self::$data['WEB_INFO']['theme']]);
        }
        self::printResult();
    }


    /* 插件设置 */
    public function plugins()
    {
        self::$data['VERIFY']['opgroup'] == 4 || self::printResult(509);
        $rowCount = 0;
        foreach ($_POST as $key => $val) {
            $rowCount = $rowCount + self::$db->exec(HandleAdminWebsetExecModel, [$val, $key, 'plugins_email']);
        }
        self::printResult();
    }

    public function pluginssendemail()
    {
        self::$data['VERIFY']['opgroup'] == 4 || self::printResult(509);

        $reveuser = $_POST['reveuser'];
        $title = $_POST['title'];
        $message = $_POST['message'];
        !empty($reveuser) && !empty($title) && !empty($message) || self::printResult(501);

        // 获取邮箱插件配置数据并引入插件本体文件
        $config = self::getSetData('plugins_email');
        require_once(HULICORE_USR_PATH . '/plugins/email/index.php');
        $result = sendMail($reveuser, $title, $message, true, $config);
        self::printResult($result);
    }


    /* 文件上传 */
    public function fileupload()
    {
        self::$data['VERIFY']['opgroup'] >= 3 || self::printResult(509);

        $file = $_FILES['file'];

        substr($file['name'], -3) == 'php' || self::printResult(510);

        $newPath = HULICORE_DATA_PATH . '/api/' . $file['name']; //新路径
        $isok = move_uploaded_file($file['tmp_name'], $newPath);
        $code = $isok ? 500 : 511;
        self::printResult($code);
    }

    public function fileupload_get()
    {
        $filename = $_POST['filename'];
        empty($filename) && self::printResult(501);

        $path = HULICORE_DATA_PATH . '/api/' . $filename;
        file_exists($path) || self::printResult(502);
        $content = file_get_contents($path);
        self::printResult($content ? 500 : 511, ['content' => $content]);
    }

    public function fileupload_save()
    {
        $filename = $_POST['filename'];
        $content = $_POST['content'];
        empty($filename) && self::printResult(501);

        $path = HULICORE_DATA_PATH . '/api/' . $filename;
        if (empty($content)) {
            $result = @unlink($path);
        } else {
            $result = file_put_contents($path, $content);
        }
        self::printResult($result ? 500 : 511);
    }
}
