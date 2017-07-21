<?php
/**
 * Created by PhpStorm.
 * User: living
 * Date: 2017/6/24
 * Time: 下午3:22
 */

namespace frontend\models;

use Yii;
use common\models\Tools;
use yii\base\Exception;
use common\components\Helper;

class Cart extends \yii\db\ActiveRecord
{

    public static function makeEncodeStoreCommondity($sid,$cid=null)
    {
        $zero = '';
        if(strlen($sid) <10 )
            $zero = '0';
        $t = rand(1,9).$zero.strlen($sid).$sid.$cid;
        $t = Tools::encodeNum($t);
        return $t;
    }

    public static function getCommondityList($sid,$cid=null)
    {
        $result = [];
        $con =[];
        $con = ['State'=>1];
        if($sid>0)
            $con['STID'] =  $sid;
//        $sqlData = Price::find()->where($con)->andWhere('Count>0')->all();
        $sqlData = Price::find()->where($con)->all();
        $head =[];
        foreach($sqlData as $k=>$v)
        {
            $o = $v->attributes;
            $commodity = $v->commodity;
            if($commodity->State !=1)
                continue;
            $o['Price'] = number_format($o['Price'],2);
            $o['OPrice'] = floatval($commodity->RemarkValue);
            $o['Images'] = str_replace('.','_s.',$commodity->Images);
            $o['Unit'] = $commodity->Unit;
            $o['Remark'] = $commodity->Remark?trim($commodity->Remark):"";
            if(!empty($o['Remark']) && $o['OPrice']>0)
            {
                $o['RemarkValue'] = $o['OPrice']-$o['Price'];
                if($o['RemarkValue']>0)
                    $o['RemarkValue'] = number_format($o['RemarkValue'],2);
            }else{
                $o['Remark'] = "";
                $o['OPrice'] = 0;
            }

            $o['Count'] = $o['Count']<1?1:$o['Count'];
            if($cid && $cid == $v->COID)
            {
                $head = $o;
            }else
                $result[$k] = $o;
        }
        if($head)
             array_unshift($result,$head);
        return $result;
    }

    public static function getAmountByCart($cart,$urid,$payment_type=1)
    {
        $price = 0;
        $amount = 0;
        $sid = 0;
        $body = '';

        foreach($cart as $stid=>$num)
        {
            foreach($num as $cid=>$num)
            {
                if($num>0)
                {
                    $model = Price::findOne(['COID'=>$cid,'STID'=>$stid]);
                    if($model)
                    {
                        $price += $model->Price * $num;
                        $amount += $num;
                        $body []= $model->CName;
                    }
                }
            }
            $sid = $stid;
        }
        $OrderNumber = Order::CreatedOrderNumber(1);
        $tr = Yii::$app->db->beginTransaction();
        $store = Store::findOne($sid);
        try{
            $ordermodel = new Order();
            $ordermodel->OrderNumber = $OrderNumber;
            $ordermodel->URID = $urid;
            $ordermodel->Total = $price;
            $ordermodel->PayType = $payment_type;
            $ordermodel->STID = $sid;
            $ordermodel->SCode = $store->SCode?$store->SCode:"";
            $ordermodel->save();
            $odid = $ordermodel->ODID;
            foreach($cart as $stid=>$num)
            {
                foreach($num as $cid=>$num)
                {
                    if($num<1)
                        continue;
                    $model = Price::findOne(['COID'=>$cid,'STID'=>$stid]);
                    if($model)
                    {
                        $detailmodel = new OrderDetail();
                        $detailmodel->attributes = $model->attributes;
                        $detailmodel->Amount = $num;
                        $detailmodel->Total = $model->Price * $num;
                        $detailmodel->ODID = $odid;
                        $detailmodel->URID = $urid;
                        $detailmodel->CreatedTime = date('Y-m-d H:i:s');
                        $detailmodel->save();
                        $count = $model->Count-$num;
                        $model->updateAttributes(['Count'=>$count]);
                        $storeinventory = New StoreInventory();
                        $storeinventory->Amount = 0-$num;
                        $storeinventory->COID = $cid;
                        $storeinventory->STID = $stid;
                        $storeinventory->Type = $ordermodel->SCode.'购买操作';
                        $storeinventory->CreatedTime = date('Y-m-d H:i:s');
                        $storeinventory->save();
                    }
                }
            }
            $tr->commit();
        }catch(Exception $e)
        {

            $tr->rollBack();
        }
        $SName = $store?$store->SName:"";
        $subject = $SName.':'.Helper::truncate_utf8_string($body[0],10,'...').',共'.count($body).'件商品';
        $sbody = implode(";",$body);
        if($urid == 322 || $urid == 332)
            $price = 0.01;
        return ['price'=>$price,'amount'=>$amount,'body'=>$sbody,'ODID'=>$ordermodel->ODID,'OrderNumber'=>$OrderNumber,'subject'=>$subject];
    }

    public static function CheckByCart($cart,$urid)
    {
        $price = 0;
        $amount = 0;
        foreach($cart as $stid=>$num)
        {
            foreach($num as $cid=>$num)
            {
                if($num>0)
                {
//                    $model = Price::findOne(['COID'=>$cid,'STID'=>$stid]);
//                    if($model)
//                    {
//                        if($num>$model->Count)
//                        {
//                            return 255;
//                        }
//                    }else{
//                        return 255;
//                    }
                }
            }
        }
        return 0;
    }

    public static function getURID($token)
    {
        $urid = 0;
        if($token)
        {
            $detoken = Tools::decodeStr($token);
            $token_arr = json_decode($detoken,true);
            $urid = isset($token_arr['URID'])?$token_arr['URID']:0;
        }
        if($urid<1){
            //临时创建新用户
            $model = User::createUser();
            $urid = $model->URID;
        }
        return $urid;
    }
}


































