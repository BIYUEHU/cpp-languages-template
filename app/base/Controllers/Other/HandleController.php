<?php

class HandleController extends Controller
{
    /* 模型Models */
    public const HitokotoGetModel = "SELECT * FROM ial_hitokoto ORDER BY id DESC";
    public const HitokotoGet2Model = "SELECT COUNT(*) FROM ial_hitokoto WHERE type = '1'";
    public const HitokotoGet3Model = "SELECT COUNT(*) FROM ial_hitokoto WHERE type = '2'";
    public const HitokotoGet4Model = "SELECT COUNT(*) FROM ial_hitokoto WHERE type = '3'";
    public const HitokotoGet5Model = "SELECT COUNT(*) FROM ial_hitokoto WHERE type = '4'";
    public const SeimgGetModel = "SELECT COUNT(*) FROM ial_seimg";
    public const SeimgGet2Model = "SELECT COUNT(*) FROM ial_seimg WHERE r18 = 'false'";
    public const SeimgGet3Model = "SELECT COUNT(*) FROM ial_seimg WHERE r18 = 'true'";

    /* 数据库实例 */
    private static $db_other;


    /* 数据库连接 */
    private static function _content()
    {
        $config = require(__DIR__ . '/Config.php');
        self::$db_other = new mysqli($config['host'], $config['userName'], $config['passWord'], $config['dbName'], $config['port']);

        if (self::$db_other->connect_error) {
            die("fail:database content failed" . self::$db_other->connect_error);
        }
    }

    private static function dbQuery($sql, $all = false) {
        self::_content();
        return $all == false ? self::$db_other->query($sql)->fetch_assoc() : self::$db_other->query($sql)->fetch_all();
    }

    private static function dbExec($sql) {
        self::_content();
        return self::$db_other->query($sql);
    }


    private function hitokotoget()
    {
        self::$data['VERIFY']['opgroup'] == 4|| self::printResult(509);

        $page = $_POST['page'] ?? 1;
        $limit = $_POST['limit'] ?? 20;
        $limit >= 1 && $limit <= 35 || self::printResult(502);

        $rows = self::dbQuery(self::HitokotoGetModel, true);
        $data = [];
        $count = 0;

        foreach ($rows as $key => $val) {
            $count++;
            if ((($page - 1) * $limit) <= $key && $key < ($page * $limit)) {
                array_push($data, array(
                    'msg' => $val[1],
                    'from' => $val[2],
                    'type' => $val[3],
                    'likes' => $val[4],
                    'view' => $val[5] == 'true' ? true : false,
                    'reg_date' => $val[6]
                ));
            }
        }

        $num = array(
            'seimg' => [
                intval(self::dbQuery(self::SeimgGetModel)['COUNT(*)']),
                intval(self::dbQuery(self::SeimgGet2Model)['COUNT(*)']),
                intval(self::dbQuery(self::SeimgGet3Model)['COUNT(*)'])
            ],
            'hitokoto' => [
                intval(self::dbQuery(self::HitokotoGet2Model)['COUNT(*)']),
                intval(self::dbQuery(self::HitokotoGet3Model)['COUNT(*)']),
                intval(self::dbQuery(self::HitokotoGet4Model)['COUNT(*)']),
                intval(self::dbQuery(self::HitokotoGet5Model)['COUNT(*)'])
            ]
        );

        self::printResult(500, [$count, $data, $num]);
    }

    private function hitokotodel()
    {
        self::$data['VERIFY']['opgroup'] == 4|| self::printResult(509);
        $msg = $_POST['msg'];
        !empty($msg) || self::printResult(501);

        self::dbExec("DELETE FROM ial_hitokoto WHERE msg = '{$msg}'");
        self::printResult();
    }

    private function hitokotoadd()
    {
        self::$data['VERIFY']['opgroup'] == 4|| self::printResult(509);
        $msg = $_POST['msg'];
        $from = $_POST['from'];
        $type = $_POST['type'];
        !empty($msg) && !empty($from) && !empty($type) || self::printResult(501);
        $view = intval($_POST['view']) == 0 ? 'false' : 'true';

        $rows = self::dbQuery("SELECT * FROM ial_hitokoto WHERE msg = '{$msg}'", true);
        count($rows) < 1 || self::printResult(508);

        self::dbExec("INSERT INTO ial_hitokoto(msg, _from, type, view) VALUES('{$msg}', '{$from}', '{$type}', '{$view}')");
        self::printResult();
    }

    private function hitokotochange()
    {
        self::$data['VERIFY']['opgroup'] == 4|| self::printResult(509);
        $msg = $_POST['msg'];
        !empty($msg) || self::printResult(501);
        $set = intval($_POST['set']) == 0 ? 'false' : 'true';
        self::dbExec("UPDATE ial_hitokoto SET view = '{$set}' WHERE msg = '{$msg}'");
        self::printResult();
    }


    public function index()
    {
        switch(self::$val) {
            case 'hitokotoget':
                self::hitokotoget();
                break;
            case 'hitokotodel':
                self::hitokotodel();
                break;
            case 'hitokotoadd':
                self::hitokotoadd();
                break;
            case 'hitokotochange':
                self::hitokotochange();
                break;
            default:
                self::error404();
        }
    }
}