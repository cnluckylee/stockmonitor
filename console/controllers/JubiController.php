<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/20
 * Time: 7:05
 */

namespace console\controllers;
use Yii;
use yii\console\Controller;
use common\models\Account;
use common\models\Order;
use common\models\Reserve;
use common\models\Tickets;

use yii\base\Exception;
use common\models\Tools;

class JubiController extends Controller
{
    private $redis;
    public function init()
    {
        $this->redis = Yii::$app->redis;
    }

    public function actionAccount()
    {
        $data = Account::getAccount();
        print_r($data->attributes);exit;
    }



    public function getTickets()
    {
        $url = 'https://www.jubi.com/api/v1/allticker/';
        $page = file_get_contents($url);
        $data = json_decode($page,true);
        return $data;
    }

    /**
     * 定时计算获利情况
     */
    public function actionRecord()
    {
        $redis = Yii::$app->redis;
        $tickets = $redis->get('jubi:tickets');

    }

    /**
     * 每个5s执行一次
     */
    public function actionCompare()
    {
        $tickets = $this->getTickets();
        $redis = Yii::$app->redis;
        $page = $redis->get('jubi:tickets');
        $redisData = json_decode($page,true);
        //避免每次都要重新跑一次数据
        $result = [];
        foreach($tickets as $k=>$v)
        {
            $v['name'] = $k;
            $row = isset($redisData[$k])?$redisData[$k]:"";
            if(!$row){
                $v['maxsell'] = $v['buy'];
                $v['minsell'] = $v['buy'];
                $result[$k] = $v;
            }else{
                if(!isset($row['maxsell'])){
                    $row['maxsell'] = $v['buy'];
                }else if($row['maxsell']<$v['buy'])
                {
                    //保存最高售价
                    $row['maxsell'] = $v['buy'];
                }

                if(!isset($row['minsell']))
                {
                    $row['minsell'] = $v['buy'];
                }else if($row['minsell']>$v['buy']){
                    //保存最低售价
                    $row['minsell'] = $v['buy'];
                }
                $row = array_merge($row,$v);
                $row['updatedtime'] = date('Y-m-d H:i:s');
               $result[$k] = $row;
            }
            $reserve = Reserve::findOne(['coin'=>$k,'uid'=>Account::getUid(),'state'=>1]);
            if($reserve)
            {
                $percent = $reserve->percent;
                $type = $reserve->type;
                if($type == 'sell')
                {
                    try{
                        echo $v['buy'].'/'.$row['maxsell'].":".$v['buy']/$row['maxsell'] ."\n";
                        if($v['buy']/$row['maxsell']<$percent)
                        {
                            $count = $reserve->count == 0?Account::getCoinNum(Account::getUid(),$k):$reserve->count;
                            $money = $count * $v['buy']*0.99;
                            $body = $k." 卖出数量".$count.',卖出价：'.$v['buy']*0.99.'，最高价：'.$row['maxsell'].',待收款:'.$money;
                            Reserve::updateAll(['state'=>2],['_id'=>$reserve->_id]);
                            $this->sendMail($k."币卖出提醒",$body);
                            $this->trade($count,$v['buy']*0.99,'sell',$k,$reserve->_id);
                        }
                    }catch(Exception $e)
                    {
                        print_r($e);exit;
                    }

                }else if($type == 'buy')
                {
                    if($row['minsell']*$percent<$v['sell'])
                    {
                        $count = $reserve->count == 0?Account::getCoinNum(Account::getUid(),$k):$reserve->count;
//                        $this->trade($count,$v['sell']*0.99,'buy',$k,$reserve->_id);
                    }
                }
            }
        }
        $redis->set('jubi:tickets',json_encode($result));
        unset($result);
//        sleep(8);
//        $this->runAction('compare');
    }



    public function actionUpdatetickets()
    {
        $page = $this->redis->get("jubi:tickets");
        $tickets = json_decode($page,true);
        //避免每次都要重新跑一次数据
        foreach($tickets as $k=>$v)
        {
            $v['name'] = $k;
            $row = Tickets::findOne(['name'=>$k]);
            if(!$row){
                $model = new Tickets();
                $v['maxsell'] = $v['sell'];
                $v['minsell'] = $v['sell'];
                $model->attributes = $v;
                $model->save();
            }else{
                Tickets::updateAll($v,['_id'=>$row->_id]);
            }
        }
//        sleep(30);
//        unset($tickets);
//        echo "Update Time:".date("Y-m-d H:i:s")."\n";
//        $this->runAction('updatetickets');
    }


    public function actionBuy()
    {
        $count = floatval(Tools::getParam('count'));
        $price = Tools::getParam('price');
        $coin = trim(Tools::getParam('coin'));
        if(($count || $price) && $coin)
        {
            $this->trade($count,$price,"buy",$coin);
        }
    }

    public function actionSell()
    {
        $count = floatval(Tools::getParam('count'));
        $price = Tools::getParam('price');
        $coin = trim(Tools::getParam('coin'));
        if(($count || $price)  && $coin)
        {
            $this->trade($count,$price,"sell",$coin);
        }
    }


    public function actionYuyue()
    {
        $count = floatval(Tools::getParam('count'));
        $price = Tools::getParam('price');
        $type = Tools::getParam('type');
        $coin = trim(Tools::getParam('coin'));
        $percent = floatval(Tools::getParam('diefu'));
        $model = new Reserve();
        $model->uid = Account::getUid();
        $model->coin = $coin;
        $model->type = $type;
        $model->price = $price;
        $model->count = $count;
        $model->percent = $percent;
        $model->createdtime = date('Y-m-d H:i:s');
        $model->state = 1;
        if($model->save())
        {
            exit("预约成功!");
        }
    }

    /**
     * 买 money为总金额
     * 卖 money为单价
     * @param null $count
     * @param null $money
     * @param $type
     * @param $coin
     * @param null $yuyue_id
     */

    public function trade($count=null,$money=null,$type,$coin,$yuyue_id = null)
    {
        if(!in_array($type,['sell','buy']))
        {
            exit("type 错误");
        }
        $url = 'https://www.jubi.com/api/v1/ticker/?coin='.$coin;
        $page = file_get_contents($url);
        $coindata = json_decode($page,true);
        $account = Account::getAccount();
        if($type == 'buy')
        {
            if($account->cny < $money){
                exit("金额不足");
            }else{
                if($money)
                {
                    $count = $money/$coindata['sell'];
                }else if($count)
                {
                    $count = $count*$coindata['sell'];
                }
                $price = $coindata['sell'];
            }
        }else if($type == 'sell')
        {
            $check = 1;
            foreach($account->data as $k=>$v)
            {
                if($v['name'] == $coin && $v['count']>=$count)
                {
                    $check = 2;
                }
            }
            if($check == 1)
            {
                exit("货币数量不足");
            }

            if(!$money)
            {
                $price = $coindata['buy'];
            }else{
                $price = $money;
            }
        }

        //交易
        $url = 'https://www.jubi.com/api/v1/trade_add/';
        $nonce = Account::getNonce();
        $params = ['key'=>Account::getKey(),'nonce'=>$nonce,
                    'amount'=>$count,'price'=>$price,'type'=>$type,'coin'=>$coin
        ];
        $str = http_build_query($params);
        $signature = hash_hmac("sha256",$str,Account::getIdKey());
        $params['signature'] = $signature;
        $page = Tools::send_post($url,$params);
        $data = json_decode($page,true);
        if($data && $data['result'] == 1 && $data['id']>0)
        {
            $model = new Order();
            $datas = ['count'=>$count,'price'=>$price,'type'=>$type,'coin'=>$coin,'jid'=>$data['id'],'createdtime'=>date("Y-m-d H:i:s")];
            $model->attributes = $datas;
            $model->save();
        }

        if($yuyue_id)
        {
            Reserve::updateAll(['state'=>2],['_id'=>$yuyue_id]);
        }
    }

    public function sendMail($subject,$body)
    {
        $mail= Yii::$app->mailer->compose();
        $mail->setTo('living10@126.com');
        $mail->setSubject($subject);
        $body = html_entity_decode($body);
        $mail->setHtmlBody($body);    //发布可以带html标签的文本
        echo $mail->send();
    }
}