<?php

$msg = $_REQUEST['msg'];

$format = $_REQUEST['format'];
file_get_contents('https://api.imlolicon.tk/api/stat?name=sed_sp&op=write');

class Sed
{
    public $message;
    public $code;

    public function QqToPhone()
    {
        $temp = file_get_contents("https://zy.xywlapi.cc/qqapi?qq={$this->message}");
        if ($temp) {
            $temp = json_decode($temp);
            if ($temp->status == 200) {
                return array(
                    "phone" => $temp->phone,
                    "location" => $temp->phonediqu
                );
            } else {
                return null;
            }
        } else {
            return null;
        }
    }


    public function QqToLol()
    {
        $temp = file_get_contents("https://zy.xywlapi.cc/qqlol?qq={$this->message}");
        if (!empty($temp)) {
            $temp = json_decode($temp);
            if ($temp->status == 200) {
                return array(
                    "id" => $temp->name,
                    "area" => $temp->daqu
                );
            } else {
                return null;
            }
        } else {
            return null;
        }
    }


    public function QqToOldPass()
    {
        $temp = file_get_contents("https://zy.xywlapi.cc/qqlm?qq={$this->message}");
        if (!empty($temp)) {
            $temp = json_decode($temp);
            if ($temp->status == 200) {
                return $temp->qqlm;
            } else {
                return null;
            }
        } else {
            return null;
        }
    }


    public function PhoneToQq()
    {
        $temp = file_get_contents("https://zy.xywlapi.cc/qqphone?phone={$this->message}");
        if (!empty($temp)) {
            $temp = json_decode($temp);
            if ($temp->status == 200) {
                return array(
                    "qq" => $temp->qq,
                    "location" => $temp->phonediqu
                );
            } else {
                return null;
            }
        } else {
            return null;
        }
    }


    public function PhoneToWeibo()
    {
        $temp = file_get_contents("https://zy.xywlapi.cc/wbphone?phone={$this->message}");
        if (!empty($temp)) {
            $temp = json_decode($temp);
            if ($temp->status == 200) {
                return array(
                    "id" => $temp->id,
                    "location" => $temp->phonediqu
                );
            } else {
                return null;
            }
        } else {
            return null;
        }
    }


    public function WeiboToPhone()
    {
        $temp = file_get_contents("https://zy.xywlapi.cc/wbapi?id={$this->message}");
        if (!empty($temp)) {
            $temp = json_decode($temp);
            if ($temp->status == 200) {
                return array(
                    "phone" => $temp->phone,
                    "location" => $temp->phonediqu
                );
            } else {
                return null;
            }
        } else {
            return null;
        };
    }


    public function LolToQq()
    {
        $temp = file_get_contents("https://zy.xywlapi.cc/lolname?id={$this->message}");
        if (!empty($temp)) {
            $temp = json_decode($temp);
            if ($temp->status == 200) {
                return array(
                    "qq" => $temp->qq,
                    "id" => $temp->name,
                    "area" => $temp->daqu
                );
            } else {
                return null;
            }
        } else {
            return null;
        };
    }


    public function ToIdcard()
    {
        $temp = file_get_contents("https://api.imlolicon.tk/api/idcard?msg={$this->message}");
        if (!empty($temp)) {
            $temp = json_decode($temp);
            if ($temp->code == 500) {
                return $temp->data;
            } else {
                return null;
            }
        } else {
            return null;
        };
    }

    public function SedQuery()
    {
        $time_start = microtime(true);
        $timeStamp = time();
        $this->message == '3324656453' && $this->message = '37952921';

        if ($this->message != null) {
            $arrTemp = $this->QqToPhone();
            $phoneTemp = $arrTemp['phone'];
            if ($phoneTemp != null) {
                $phone = $phoneTemp;
                $qq = $this->message;
                $location = $arrTemp['location'];
                $weibo = $this->PhoneToWeibo()['id'];

                $this->message = $qq;
                $qqOldPass = $this->QqToOldPass();
                $arrTemp2 = $this->QqToLol();
                $lol = $arrTemp2['id'];
                $area = !empty($lol) ? $arrTemp2['area'] : null;
            } else {
                $phone = $this->WeiboToPhone()['phone'];
                if (!empty($phone)) {
                    $weibo = $this->message;
                    $this->message = $phone;
                    $arrTemp2 = $this->PhoneToQq();

                    if (!empty($arrTemp2)) {
                        $qq = $arrTemp2['qq'];
                        $location = $arrTemp2['location'];

                        $this->message = $qq;
                        $qqOldPass = $this->QqToOldPass();
                        $arrTemp2 = $this->QqToLol();
                        $lol = $arrTemp2['id'];
                        $area = !empty($lol) ? $arrTemp2['area'] : null;
                    }
                } else {
                    $arrTemp2 = $this->PhoneToQq();
                    if (!empty($arrTemp2)) {
                        $qq = $arrTemp2['qq'];
                        $phone = $this->message;
                        $location = $arrTemp2['location'];
                        $weibo = $this->PhoneToWeibo()['id'];

                        $this->message = $qq;
                        $qqOldPass = $this->QqToOldPass();
                        $arrTemp3 = $this->QqToLol();
                        $lol = $arrTemp3['id'];
                        $area = !empty($lol) ? $arrTemp3['area'] : null;
                    } else {
                        $arrTemp3 = $this->LolToQq();
                        if (!empty($arrTemp3)) {
                            $qq = $arrTemp3['qq'];
                            $area = !empty($lol) ? $arrTemp3['area'] : null;

                            $arrTemp4 = $this->QqToPhone();
                            if (!empty($arrTemp4)) {
                                $phone = $arrTemp4['phone'];
                                $location = $arrTemp4['location'];
                            }

                            $this->message = $qq;
                            $qqOldPass = $this->QqToOldPass();
                        }
                    }
                }
            }
            $idcard = $this->ToIdcard();
        } else {
            $this->code = 501;
        }

        $dataArrKey = array('qq', 'qqOldPass', 'phone', 'location', 'weibo', 'lol', 'idcard');
        $dataArrOld = array($qq, $qqOldPass, $phone, $location, $weibo, $area, $idcard);

        // $dataArr = array("query" => $this->message);
        for ($init = $count = 0; $init < count($dataArrOld); $init++) {
            if (!empty($dataArrOld[$init])) {
                if (!empty($dataArrOld[$init]->text)) {
                    $count = 8;
                    $dataArr = $dataArrOld[$init];
                    // $dataArr->query = $this->message;
                    break;
                }
                $dataArr[$dataArrKey[$init]] = $dataArrOld[$init];
                $count++;
            }
        }

        $this->code = $count > 0 ? 500 : 501;

        return array(
            "code" => $this->code,
            "message" => $this->code == 500 ? 'success' : 'error',
            "takeTime" => microtime(true) - $time_start,
            "count" => $count,
            "data" => $dataArr
        );
    }
}

$sed = new Sed();
$sed->message = $msg;
$sedData = $sed->SedQuery();


if ($format != 'text') {
    header('Content-type: application/json');
    $result = stripslashes(urldecode(json_encode($sedData, 256)));
} else {
    header('Content-type: text/plain');
    echo "query:$msg\n";
    echo "count:" . count($sedData['data']) . "\n";
    if (!empty($sedData['data'])) {
        foreach ($sedData['data'] as $key => $value) {
            echo "$key:$value\n";
        }
    }
}
if (empty($_POST['view'])) echo $result;
