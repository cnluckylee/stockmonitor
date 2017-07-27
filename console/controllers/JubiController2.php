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
use common\models\Tools;
use yii\mongodb\Query;

class JubiController extends Controller
{
    public function actionAccount()
    {
//        $this->trade(1.00,10.00,'sell','lkc');
//        exit;
        $url = 'https://www.jubi.com/api/v1/balance/';
        $nonce = date('y').time();
        $sy = md5('@Bh*Z-3^DPK-!Jr4^-j;.;}-~cyp.-^ac&8-kZJDU');
        $params = ['key'=>'ni5su-g43bt-zqknh-xs3cx-rxj36-ciaph-ub1z4','nonce'=>$nonce];
        $str = http_build_query($params);
        $signature = hash_hmac("sha256",$str,$sy);
        $params['signature'] = $signature;
        $page = Tools::send_post($url,$params);
        $data = json_decode($page,true);

        $asset = $data['asset'];//RMB
        $cny = $data['cny_balance'];//RMB
        $alltickets = $this->updateRecod();
        $myticket = [];
        foreach($data as $k=>$num){
            if((strpos($k,'balance') != false || strpos($k,'lock') != false) && $num>1) {
                if(strpos($k,'balance') != false)
                    $coin = str_replace('_balance','',$k);
                else if(strpos($k,'lock') != false)
                    $coin = str_replace('_lock','',$k);
                $sell = 0;
                if(isset($alltickets[$coin]))
                {
                    $ticketinfo = $alltickets[$coin];
                    $sell = $ticketinfo['sell'];
                }
                $money = $num*$sell;
                if($money>0){
                    $money = number_format($money,2);
                    if(isset($myticket[$coin]))
                        $myticket[$coin] += $money;
                    else
                        $myticket[$coin] = $money;
                    //出发买卖交易
                    if($ticketinfo['maxsell']*0.95>$ticketinfo['sell'])
                    {
                        $myfile = fopen("/tmp/trade.log", "a+");
                        $txt = $coin."\n";
                        fwrite($myfile, $txt);
                        fclose($myfile);
                        //触发卖交易
//                        $this->trade($num,$sell,'sell',$coin);
                    }
                    $myticket[$coin.'_max'] = number_format($num*$ticketinfo['maxsell'],2);
                    $myticket[$coin.'_min'] = number_format($num*$ticketinfo['minsell'],2);
                    $myticket[$coin.'_count'] = $num;
                }
            }
        }
        $myticket['Amount'] = $asset;
        $myticket['Cny'] = $cny;
        $myticket['UpdatedTime'] = date('Y-m-d H:i:s');
        $collection = Yii::$app->mongodb->getCollection('account');
        $row = $collection->findOne();
        if($row)
            $collection->update(['_id'=>$row['_id']],$myticket);
        else
            $collection->insert($myticket);
        exit(1);
    }



    public function getTickets()
    {
        $url = 'https://www.jubi.com/api/v1/allticker/';
        $page = file_get_contents($url);
        $data = json_decode($page,true);
        return $data;
    }

    public function updateRecod()
    {
        $tickets = $this->getTickets();
        //避免每次都要重新跑一次数据
        $collection = Yii::$app->mongodb->getCollection('tickets');
        $result = [];
        foreach($tickets as $k=>$v)
        {
            $v['name'] = $k;
            $row = $collection->findOne(['name'=>$k]);
            if(!$row){
                $v['maxsell'] = $v['minsell'] = $v['sell'];
                $collection->insert($v);
            }else{
                if($row['maxsell']<$v['sell'])
                {
                    //保存最高售价
                    $v['maxsell'] = $v['sell'];
                }else{
                    $v['maxsell'] = $row['maxsell'];
                }
                if($row['minsell']>$v['sell']){
                    //保存最低售价
                    $v['minsell'] = $v['sell'];
                }else
                    $v['minsell'] = $row['minsell'];
                $collection->update(['_id'=>$row['_id']],$v);
            }
            $result[$v['name']] = $v;
        }
        return $result;
    }


    public function trade($amount,$price,$type,$coin)
    {
        //交易
        $url = 'https://www.jubi.com/api/v1/trade_add/';
        $nonce = date('y').time();
        $sy = md5('@Bh*Z-3^DPK-!Jr4^-j;.;}-~cyp.-^ac&8-kZJDU');
        $params = ['key'=>'ni5su-g43bt-zqknh-xs3cx-rxj36-ciaph-ub1z4','nonce'=>$nonce,
                    'amount'=>$amount,'price'=>$price,'type'=>$type,'coin'=>$coin
        ];
        $str = http_build_query($params);
        $signature = hash_hmac("sha256",$str,$sy);
        $params['signature'] = $signature;
        $page = Tools::send_post($url,$params);
        $data = json_decode($page,true);
        if($data && $data['id']>0)
        {
            $collection = Yii::$app->mongodb->getCollection('order');
            $datas = ['amount'=>$amount,'price'=>$price,'type'=>$type,'coin'=>$coin,'id'=>$data['id']];
            $collection->insert($datas);
        }
    }
}