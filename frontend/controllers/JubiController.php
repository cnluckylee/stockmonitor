<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/20
 * Time: 7:05
 */

namespace frontend\controllers;
use app\models\Account;
use app\models\Order;
use app\models\Reserve;
use app\models\Tickets;
use Yii;

use yii\web\Controller;
use common\models\Tools;
use yii\mongodb\Query;

class JubiController extends Controller
{
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

    public function actionUpdatetickets()
    {
        $tickets = $this->getTickets();
        //避免每次都要重新跑一次数据
        $result = [];
        foreach($tickets as $k=>$v)
        {
            $v['name'] = $k;
            $row = Tickets::findOne(['name'=>$k]);
            if(!$row){
                $model = new Tickets();
                $v['maxsell'] = $v['sell'];
                $v['minsell'] = $v['sell'];
                $model->attributes = $v;
                $row = $model->save();
            }else{
                $row->attributes = $v;
                if($row->maxsell<$v['sell'])
                {
                    //保存最高售价
                    $row->maxsell = $v['sell'];
                }else{
                    $row->maxsell = $row['maxsell'];
                }
                if($row->minsell>$v['sell']){
                    //保存最低售价
                    $row->minsell = $v['sell'];
                }else
                    $row->minsell = $row['minsell'];
                $row->updatedtime = date('Y-m-d H:i:s');
                $d = $row->attributes;
                unset($d['_id']);
                Tickets::updateAll($row->attributes,['_id'=>$row->_id]);
            }
            $reserve = Reserve::findOne(['coin'=>$k,'uid'=>Account::getUid()]);
            if($reserve)
            {
                $percent = $reserve->percent;
                if($row->maxsell*$percent<$v['sell'])
                {
                    $count = $reserve->count == 0?Account::getCoinNum(Account::getUid(),$k):$reserve->count;
                    $this->trade($count,$v['sell']*0.99,'sell',$k,$reserve->_id);
                }
            }
            $result[$row->name] = $row->attributes;
        }
        print_r($result);exit;
//        return $result;
    }


    public function actionBuy()
    {
        $count = floatval(Tools::getParam('count'));
        $price = Tools::getParam('price');
        $type = Tools::getParam('type');
        $coin = trim(Tools::getParam('coin'));
        if(($count || $price) && $type && $coin)
        {
            $this->trade($count,$price,$type,$coin);
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


    public function trade($count=null,$price=null,$type,$coin,$yuyue_id = null)
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
            if($account->cny < $price){
                exit("金额不足");
            }else{
                $price = $coindata['sell'];
                if($price)
                {
                    $count = $price/$coindata['sell'];
                }else if($count)
                {
                    $count = $count*$coindata['sell'];
                }
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
            if(!$price)
            {
                $price = $coindata['buy'];
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
            $datas = ['count'=>$count,'price'=>$price,'type'=>$type,'coin'=>$coin,'jid'=>$data['id']];
            $model->attributes = $datas;
            $model->save();
        }

        if($yuyue_id)
        {
            Reserve::updateAll(['state'=>2],['_id'=>$yuyue_id]);
        }
    }
}