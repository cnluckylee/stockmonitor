<?php
namespace frontend\controllers;

use common\components\Helper;
use frontend\models\Cart;
use frontend\models\OrderDetail;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\log\Logger;
use common\models\Tools;
use yii\alipay\AlipayNotify;
use yii\alipay\AlipaySubmit;
use frontend\models\User;
use frontend\models\Order;
use yii\alipay\AlipaySubmitNew;
use yii\wxpay\WxpaySubmitNew;


class PayController extends Controller
{
//    public $layout = 'cart';
    public $enableCsrfValidation = false;


    public function actionSubmit()
    {
        $cart = Tools::getArrayParam('num',"",'post');
        $token = Tools::getArrayParam('token',"",'post');
        $payment_type = Tools::getArrayParam('payment_type',1,'post');
        $urid = Cart::getURID($token);
        $cartArr = Cart::getAmountByCart($cart,$urid);
        $total_amount = $cartArr['price'];
        $out_trade_no = $cartArr['OrderNumber'];
        $body = $cartArr['body'];
        $subject = $cartArr['subject'];
       if($payment_type == 1)
        {
            //支付宝交易
            AlipaySubmitNew::Submit($body,$subject,$out_trade_no,$total_amount);
        }else if($payment_type == 2)
       {
           WxpaySubmitNew::Submit($body,$subject,$out_trade_no,$total_amount);
       }
        exit;
    }



    public function actionNotify()
    {
        $s = $_POST;
        if($s)
        {
            $str = strtolower(json_encode($s));
            if(strpos($str,'alipayaccount')) {
                AlipaySubmitNew::Notify();
            }
        }else{
            $raw_xml = file_get_contents("php://input");
            if($raw_xml)
            {
                WxpaySubmitNew::Notify();
            }
        }
    }

    public function actionQuery()
    {
       $t = Tools::getParam('t');
       $a = WxpaySubmitNew::Query($t);
        print_r($a);exit;
    }

    public function actionReturn()
    {
        $ordernumber = Tools::getParam('out_trade_no');
        $order = Order::findOne(['OrderNumber'=>$ordernumber]);
        if($order && $order->State != 1)
        {
            //再查一次
            $trade_no = Tools::getParam('trade_no');
            if($order->PayType == 1)
            {
                $response = AlipaySubmitNew::Query($trade_no);
                if($response->trade_status == 'TRADE_FINISHED' || $response->trade_status == 'TRADE_SUCCESS')
                {
                    $order->updateAttributes(['State'=>1]);
                }
            }else if($order->PayType == 2)
            {
                $response = WxpaySubmitNew::Query(null,$ordernumber);
                if($response['result_code'] == 'SUCCESS')
                {
                    $order->updateAttributes(['State'=>1]);
                }
            }
        }
        if($order)
        {
            $ODID = $order->ODID;
            $orderdetail = OrderDetail::getGoodsByODID($ODID);
            return $this->render('return',[
                'goods'=>$orderdetail,
                'totalnum'=>count($orderdetail),
                'totalprice'=>number_format($order->PayAmount,2),
            ]);
        }else{
            return $this->render('OK',[

            ]);
        }
    }
}