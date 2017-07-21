<?php

namespace console\controllers;

use frontend\models\Price;
use frontend\models\Store;
use Yii;
use yii\console\Controller;

use frontend\models\Order;
use frontend\models\StoreInventory;

/**
 * UserLogController implements the CRUD actions for LUserLog model.
 */
class StockController extends Controller
{
    public  function actionCheckorder()
    {
        $orders = Order::find()->where(['State'=>0])->andWhere('CreatedTime<="'.date('Y-m-d H:i:s',strtotime(' -10 minute')).'"')->all();
        if($orders)
        {
            foreach($orders as $k=>$order)
            {
                $details = $order->detail;
                foreach($details as $kk=>$detail)
                {
                    $price = Price::findOne($detail->PRID);
                    $storeinventory = New StoreInventory();
                    $storeinventory->Amount = $detail->Amount;
                    $storeinventory->COID = $price->COID;
                    $storeinventory->STID = $detail->STID;
                    $store = Store::findOne($detail->STID);
                    $sname = $store?$store->SName:"";
                    $storeinventory->Type = $sname.'购买失败回库操作';
                    $storeinventory->CreatedTime = date('Y-m-d H:i:s');
                    $storeinventory->save();
                    $count = $price->Count+$detail->Amount;
                    $price->updateAttributes(['Count'=>$count]);
                }
                $ntime = date('Y-m-d H:i:s');
                $order->updateAttributes(['State'=>2,'UpdatedTime'=>$ntime]);
            }
        }
        exit(1);
    }
}
