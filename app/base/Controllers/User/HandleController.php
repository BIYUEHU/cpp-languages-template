<?php

namespace Base\Controllers\User;

use Base\Controllers\Controller;
use Lib\Stat;
use function Core\Func\getKey;

class HandleController extends Controller
{
    /* 登录 */
    public function login()
    {
        // 验证是否登录
        !self::$data['VERIFY'] || self::printResult(509);
        // 根据记录的SESSION判断图片验证码是否正确
        $_SESSION['captchaimg_num'] == $_POST['captchaimg'] || self::printResult(510);
        // 判断账号密码是否正确
        $data = self::$db->fetch(HandleUserLoginModel, [$_POST['email'], $_POST['password']]);
        !empty($data) || self::printResult(502);
        $_SESSION['hulicore_loginaccount'] = array(
            "email" => $_POST['email'],
            "password" => $_POST['password'],
            "rand" => rand(0, 23333),
            "time" => time()
        );
        self::verifyLogin();
        self::printResult(500, [
            'name' => self::$data['VERIFY']['name']
        ]);
    }


    /* 注册 */
    public function register()
    {
        // 验证是否登录
        !self::$data['VERIFY'] || self::printResult(509);

        // 根据记录的SESSION判断图片验证码是否正确
        $_SESSION['captchaimg_num'] == $_POST['captchaimg'] || self::printResult(510);

        $name = $_POST['name'];
        $email = $_POST['email'];
        !empty($name) && !empty($email) || self::printResult(501);

        preg_match_all('/(.*?)@(.*)/', $email, $match);
        !empty($match[1]) || self::printResult(502);

        $rows = self::$db->fetchAll(HandleAdminAccountaddCheckModel, [$name, $email]);
        count($rows) < 1 || self::printResult(508);

        $password = substr(\Core\Func\getKey(), 0, 10);
        $ip = \Core\Func\getUserIp();

        $rowCount = self::$db->exec(HandleAdminAccountaddExecModel, [
            $name, $email, $password, 3,
            $ip, self::$data['WEB_INFO']['startcoin']
        ]);

        
        $title = '恭喜您成功注册 ' . self::$data['WEB_INFO']['webtitle'] . ' !';
        $url = self::$data['WEB_INFO']['weburl'] . APP_USER_PATH . '/login';
        $message = "您的登录密码是: <strong>$password</strong><br>请凭借本密码登录并修改为您自己的密码<br>登录地址: <a href=\"$url\">$url</a><br>如若非您本人操作请忽略该邮件";
        // 获取邮箱插件配置数据并引入插件本体文件
        $config = self::getSetData('plugins_email');
        require_once(HULICORE_USR_PATH . '/plugins/email/index.php');
        $result = sendMail($email, $title, $message, true, $config);
        self::printResult($result);

        $rowCount > 0 ? self::printResult() : self::printResult(502);
    }


    public function apilist()
    {
        self::$data['VERIFY']['opgroup'] >= 3 || self::printResult(509);

        // 页数和数量
        $page = $_POST['page'] ?? 1;
        $limit = $_POST['limit'] ?? 20;
        $limit >= 1 && $limit <= 35 || self::printResult(502);
        
        $rows = self::$db->fetchAll(HandleUserApilistModel, [self::$data['VERIFY']['id']]);
        $data = [];
        $count = 0;

        // 遍历获取到的所有数据
        foreach ($rows as $key => $val) {
            $count++;
            // 根据页数和数量填充相应部分数据到新数组内
            if ((($page - 1) * $limit) <= $key && $key < ($page * $limit)) {
                $val2 = self::$db->fetch(PageDocModel, [$val['api']]);
                array_push($data, array(
                    'title' => $val2['title'],
                    'subtitle' => $val2['subtitle'],
                    'idstr' => $val2['idstr'],
                    'apikey' => $val['apikey'],
                    'stat' => Stat::QueryTag('user_' . self::$data['VERIFY']['id'] .':' . $val2['idstr'] . '_' . Stat::StatName),
                    'ctime' => $val['ctime']
                ));
            }
        }

        self::printResult(500, [$count, $data]);
    }

    public function apilistreset()
    {
        self::$data['VERIFY']['opgroup'] >= 3 || self::printResult(509);

        $idstr = $_POST['idstr'];
        $row = self::$db->fetch(PageDocApikeyModel, [self::$data['VERIFY']['id'], $idstr]);
        $idstr && $row || self::printResult(501);
        strtotime($row['ctime']) > time() || self::printResult(510);

        self::$db->exec(HandleUserApilistResetModel, [getKey(), self::$data['VERIFY']['id'], $idstr]);
        self::printResult(500);
    }

    public function apilistcontinue()
    {
        $opgroup = self::$data['VERIFY']['opgroup'];
        $opgroup >= 3 || self::printResult(509);

        $idstr = $_POST['idstr'];
        $idstr || self::printResult(501);
        
        $row = self::$db->fetch(PageDocApikeyModel, [self::$data['VERIFY']['id'], $idstr]);
        empty($row['api']) && self::printResult(502);

        $data = self::$db->fetch(PageDocModel, [$idstr]);
        $coinAfter = self::$data['VERIFY']['coin'] - $data['coin'];
        (strtotime($row['ctime']) > time() || $coinAfter < 0) && $opgroup != 4 && self::printResult(510);
        self::$db->exec(HandleUserApishopBuyExec2Model, [$coinAfter, self::$data['VERIFY']['id']]);
        $ctime = date("Y-m-d h:i:s", time() + (30 * 24 * 60 * 60));
        self::$db->exec(HandleUserApilistContinueModel, [$ctime, self::$data['VERIFY']['id'], $idstr]);
        self::printResult();
    }


    public function apishop()
    {
        self::$data['VERIFY']['opgroup'] >= 3 || self::printResult(509);

        // 页数和数量
        $page = $_POST['page'] ?? 1;
        $limit = $_POST['limit'] ?? 20;
        $limit >= 1 && $limit <= 35 || self::printResult(502);
        
        // 获取所有正常接口数据
        $rows = self::$db->fetchAll(ControllerGetApiINumModel, [1]);
        $data = [];
        $count = 0;

        // 遍历获取到的所有数据
        foreach ($rows as $key => $val) {
            $count++;
            // 根据页数和数量填充相应部分数据到新数组内
            if ((($page - 1) * $limit) <= $key && $key < ($page * $limit)) {
                array_push($data, array(
                    'title' => $val['title'],
                    'subtitle' => $val['subtitle'],
                    'idstr' => $val['idstr'],
                    'returnType' => $val['returnType'],
                    'requestType' => $val['requestType'],
                    'coin' => $val['coin']
                ));
            }
        }

        self::printResult(500, [$count, $data]);
    }


    public function apishopbuy()
    {
        self::$data['VERIFY']['opgroup'] >= 3 || self::printResult(509);

        // 检查参数
        $idstr = $_POST['idstr'];
        $idstr || self::printResult(501);

        $rows = self::$db->fetchAll(HandleUserApishopBuyCheckModel, [self::$data['VERIFY']['id'], $idstr]);
        $data = self::$db->fetch(PageDocModel, [$idstr]);
        $coinAfter = self::$data['VERIFY']['coin'] - $data['coin'];
        (count($rows) > 0 || empty($data) || $coinAfter < 0) && self::printResult(502);

        self::$db->exec(HandleUserApishopBuyExec2Model, [$coinAfter, self::$data['VERIFY']['id']]);
        $ctime = date("Y-m-d h:i:s", time() + (30 * 24 * 60 * 60));
        self::$db->exec(HandleUserApishopBuyExecModel, [self::$data['VERIFY']['id'], $idstr, getKey(), $ctime]);
        Stat::AddTag('user_' . self::$data['VERIFY']['id'] .':' . $idstr . '_' . Stat::StatName);
        Stat::AddTag('user_' . self::$data['VERIFY']['id'] . ':total');
        self::printResult();
    }


    /* 站点接入 */
    public function website()
    {
        self::$data['VERIFY']['opgroup'] >= 3 || self::printResult(509);

        $website = $_POST['website'];
        self::$db->exec(HandleUserWebsiteModel, [$website, self::$data['VERIFY']['id']]);
        self::printResult();
    }


    /* 个人资料 */
    public function person()
    {
        self::$data['VERIFY']['opgroup'] >= 3 || self::printResult(509);

        $password = $_POST['password'];
        $passwordnew = $_POST['passwordnew'];
        !empty($password) && !empty($passwordnew) || self::printResult(501);

        $data = self::$db->fetch(HandleUserLoginModel, [self::$data['VERIFY']['email'], $password]);
        !empty($data) || self::printResult(502);

        self::$db->exec(HandleUserPersonPasswordModel, [$passwordnew, self::$data['VERIFY']['email']]);
        self::printResult();
    }

    public function personupload()
    {
        self::$data['VERIFY']['opgroup'] >= 3 || self::printResult(509);

        $file = $_FILES['file'];
        $type = $file['type'];
        $size = $file['size'];

        (($type == 'image/png' || $type == 'image/jpeg') && $size <= 1024 * 1024) || self::printResult(510);

        $newPath = HULICORE_DATA_PATH . '/account/' . self::$data['VERIFY']['id'] . '.png';//新路径
        $isok = move_uploaded_file($file['tmp_name'], $newPath);
        $code = $isok ? 500 : 511;
        // self::printResult($code, [$size, $type, $_FILES, $newPath, $isok]);
        self::printResult($code);
    }
}
