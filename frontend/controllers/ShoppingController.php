<?php
namespace frontend\controllers;


use frontend\models\Cart;
use frontend\models\User;
use Yii;
use yii\web\Controller;
use common\models\Tools;
use yii\wxpay\WxpaySubmitNew;
use yii\wxpay\JsApiPay;
/**
 * Shopping controller
 */
class ShoppingController extends Controller
{
    public function actionCart()
    {
        $t = Tools::getParam('t');
        if(Tools::is_weixin() && empty(Tools::TSession('openid')))
        {
            $tools = new JsApiPay();
            $openId = $tools->GetOpenid();
            Tools::TSession('openid',$openId);
        }
//        echo Cart::makeEncodeStoreCommondity(20,18);exit;

        $sid = $cid = 0;
        if($t && Tools::decodeNum($t)>0)
        {
            $nu = Tools::decodeNum($t);
            $pidnum = substr($nu,1,2);
            $pidnum = intval($pidnum);

            $sid = substr($nu,3,$pidnum);
            $cid = substr($nu,($pidnum+3));
        }
        $pageArray = [];
        $pageArray['goods'] = Cart::getCommondityList($sid,$cid);
        $this->view->title = '大海航购物';
        $pageArray['cid'] = $cid;
        $cartconfig = ['payment_type'=>1];
        $pageArray['cartconfig'] = json_encode($cartconfig);
        return $this->render('cart',$pageArray);
    }

    public function actionGetuser()
    {
        $token = Tools::getParam('token','','post');
        $result = ['error'=>0,'token'=>$token];
        $urid = 0;
        if($token)
        {
            $detoken = Tools::decodeStr($token);
            $token_arr = json_decode($detoken,true);
            $urid = isset($token_arr['URID'])?$token_arr['URID']:0;
        }
        if($urid<1)
        {
            $model = User::createUser();
            $r = ['URID'=>$model->URID,'LastLogin'=>$model->LastLogin];
            $str = Tools::encodeStr(json_encode($r));
            $result = ['errno'=>1,'token'=>$str];
        }
        Tools::jsonOut($result);
    }

    public function actionT()
    {
        $str = '{"16":{"16":"1","35":"0","29":"0","32":"0","23":"0","21":"0","27":"0","48":"0","47":"0","18":"0","20":"0","36":"0","28":"0","15":"0","25":"0","26":"0","24":"0","30":"0","31":"0","33":"0","10":"0","19":"0","22":"0","52":"0","54":"0","56":"0","58":"0","57":"0","55":"0","62":"0","61":"0","60":"0","63":"0","13":"0","14":"0","12":"0"}}';
        $a = json_decode($str,true);
        print_r($a);exit;
        echo Tools::TSession('openid');exit;
    }

    public function actionCheck()
    {
        $cart = Tools::getArrayParam('num',"",'post');
        $token = Tools::getArrayParam('token',"",'post');
        $payment_type = Tools::getArrayParam('payment_type',1,'post');
        $urid = Cart::getURID($token);
        $error = Cart::CheckByCart($cart,$urid);
        $result = ["errno"=>$error];
        if($error == 0 && $payment_type == 2){
            $cartArr = Cart::getAmountByCart($cart,$urid,$payment_type);
            $total_amount = $cartArr['price'];
            $out_trade_no = $cartArr['OrderNumber'];
            $body = $cartArr['body'];
            $subject = $cartArr['subject'];
            $result['wxpayconfig'] = WxpaySubmitNew::Submit($body,$subject,$out_trade_no,$total_amount);
            $result['out_trade_no'] = $out_trade_no;
        }
        Tools::jsonOut($result);
    }
}
