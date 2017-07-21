<?php
namespace yii\wxpay;
/**
 * Created by PhpStorm.
 * User: living
 * Date: 2017/7/3
 * Time: 下午5:16
 */

use frontend\models\Order;
use frontend\models\OrderDetail;
use Yii;
use yii\wxpay\JsApiPay;
use common\models\Tools;
use yii\wxpay\lib\WxPayUnifiedOrder;
use yii\wxpay\lib\WxPayOrderQuery;
use yii\wxpay\lib\WxPayApi;


class WxpaySubmitNew
{
    public static function Submit($body,$subject,$out_trade_no,$total_amount)
    {
        $config = Yii::$app->params['wxpay'];
        $tools = new JsApiPay();
        $openId = Tools::TSession('openid');
//        $openId = 'o0Z1lwKSGltAHD9ts3A674RgYuxg';
        $attach = ['out_trade_no'=>$out_trade_no,'total_amount'=>$total_amount];
        $attach = Tools::encodeStr(json_encode($attach));

//②、统一下单
        $total_amount = $total_amount *100;
        $input = new WxPayUnifiedOrder();
        $input->SetBody($body);
        $input->SetAttach($attach);
        $input->SetOut_trade_no($out_trade_no);
        $input->SetTotal_fee($total_amount);
        $input->SetTime_start(date("YmdHis"));
        $input->SetTime_expire(date("YmdHis", time() + 600));
        $input->SetGoods_tag($subject);
        $input->SetNotify_url($config['notifyurl']);
        $input->SetTrade_type("JSAPI");
        $input->SetOpenid($openId);
        $order = WxPayApi::unifiedOrder($input);
        $jsApiParameters = $tools->GetJsApiParameters($order);
        $jsApiParameters = json_decode($jsApiParameters,true);
        return $jsApiParameters;
    }


    public static function Notify()
    {
        $raw_xml = file_get_contents("php://input");
        libxml_disable_entity_loader(true);
        $res = json_encode(simplexml_load_string($raw_xml,'SimpleXMLElement',LIBXML_NOCDATA));
        $data = json_decode($res,true);
        $xml ="";
        if($data['result_code'] == 'SUCCESS')
        {
            $values = array("return_code"=>'SUCCESS','return_msg'=>'OK');
            $xml = "<xml>";
            foreach ($values as $key=>$val)
            {
                if (is_numeric($val)){
                    $xml.="<".$key.">".$val."</".$key.">";
                }else{
                    $xml.="<".$key."><![CDATA[".$val."]]></".$key.">";
                }
            }
            $xml.="</xml>";
            $out_trade_no = $data['out_trade_no'];
            $trade_no = $data['transaction_id'];
            $query = self::Query($trade_no);
            if($query['result_code'] == 'SUCCESS')
                self::updateOrder($out_trade_no,$trade_no,$data);
        }
        echo $xml;exit;
    }

    public  static function updateOrder($out_trade_no,$trade_no,$arr)
    {
        $order = Order::findOne(['OrderNumber'=>$out_trade_no]);
        if($order && empty($order->PayString))
        {
            $notify_time = date('Y-m-d H:i:s');
            $payamount = number_format($arr['total_fee']/100,2);
            $order->updateAttributes(['PayString'=>json_encode($arr),'State'=>1,'PayTime'=>$notify_time,'OrderID'=>$trade_no,'PayAmount'=>$payamount]);
        }
    }

    public static function Query($transaction_id=null,$out_trade_no=null)
    {
        if(empty($transaction_id) && empty($out_trade_no))
            return ;
        $input = new WxPayOrderQuery();
        if($transaction_id)
            $input->SetTransaction_id($transaction_id);
        else if($out_trade_no)
            $input->SetOut_trade_no($out_trade_no);
        $result = WxPayApi::orderQuery($input);
        return $result;
    }
}