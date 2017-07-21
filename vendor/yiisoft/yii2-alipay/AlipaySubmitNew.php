<?php
namespace yii\alipay;
/**
 * Created by PhpStorm.
 * User: living
 * Date: 2017/7/3
 * Time: 下午5:16
 */

use frontend\models\Order;
use frontend\models\OrderDetail;
use Yii;
use yii\alipay\buildermodel\AlipayTradeWapPayContentBuilder;
use yii\alipay\buildermodel\AlipayTradeQueryContentBuilder;
use yii\alipay\service\AlipayTradeService;
use common\models\Tools;


class AlipaySubmitNew
{
    public static function Submit($body,$subject,$out_trade_no,$total_amount,$timeout_express='1m')
    {
        $config = Yii::$app->params['alipay'];
        $payRequestBuilder = new AlipayTradeWapPayContentBuilder();
        $payRequestBuilder->setBody($body);
        $payRequestBuilder->setSubject($subject);
        $payRequestBuilder->setOutTradeNo($out_trade_no);
        $payRequestBuilder->setTotalAmount($total_amount);
        $payRequestBuilder->setTimeExpress($timeout_express);
        $payResponse = new AlipayTradeService($config);
        $result=$payResponse->wapPay($payRequestBuilder,$config['return_url'],$config['notify_url']);
    }

    public static function Notify()
    {
        $arr=$_POST;
        $config = Yii::$app->params['alipay'];
        $alipaySevice = new AlipayTradeService($config);
//        $alipaySevice->writeLog(var_export($_POST,true));
        $result = $alipaySevice->check($arr);
        /* 实际验证过程建议商户添加以下校验。
        1、商户需要验证该通知数据中的out_trade_no是否为商户系统中创建的订单号，
        2、判断total_amount是否确实为该订单的实际金额（即商户订单创建时的金额），
        3、校验通知中的seller_id（或者seller_email) 是否为out_trade_no这笔单据的对应的操作方（有的时候，一个商户可能有多个seller_id/seller_email）
        4、验证app_id是否为该商户本身。
        */

        if($result) {//验证成功
            /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            //请在这里加上商户的业务逻辑程序代
            //——请根据您的业务逻辑来编写程序（以下代码仅作参考）——
            //获取支付宝的通知返回参数，可参考技术文档中服务器异步通知参数列表
            //商户订单号
            $out_trade_no = $_POST['out_trade_no'];
            //支付宝交易号
            $trade_no = $_POST['trade_no'];
            //交易状态
            $trade_status = $_POST['trade_status'];
            if($trade_status == 'TRADE_FINISHED') {
                //判断该笔订单是否在商户网站中已经做过处理
                //如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
                //请务必判断请求时的total_amount与通知时获取的total_fee为一致的
                //如果有做过处理，不执行商户的业务程序
                //注意：
                //退款日期超过可退款期限后（如三个月可退款），支付宝系统发送该交易状态通知
                self::updateOrder($out_trade_no,$trade_no,$arr);
            }else if ($trade_status == 'TRADE_SUCCESS') {
                self::updateOrder($out_trade_no,$trade_no,$arr);
            }
            //——请根据您的业务逻辑来编写程序（以上代码仅作参考）——
            echo "success";		//请不要修改或删除
            exit();
        }else {
            $myfile = fopen("/tmp/alipaynotify.log", "a+");
            $txt = "失败了！";
            fwrite($myfile, $txt);
            fclose($myfile);
            //验证失败
            echo "fail";	//请不要修改或删除
            exit();
        }
    }

    public  static function updateOrder($out_trade_no,$trade_no,$arr)
    {
        $order = Order::findOne(['OrderNumber'=>$out_trade_no]);
        if($order && empty($order->PayString))
        {
            $notify_time = Tools::getParam('notify_time','','post');
            $payamount = $arr['receipt_amount'];
            $order->updateAttributes(['PayString'=>json_encode($arr),'State'=>1,'PayTime'=>$notify_time,'OrderID'=>$trade_no,'PayAmount'=>$payamount]);
        }
    }

    public static function Query($trade_no)
    {
        $RequestBuilder = new AlipayTradeQueryContentBuilder();
        $RequestBuilder->setTradeNo($trade_no);
        $config = Yii::$app->params['alipay'];
        $Response = new AlipayTradeService($config);
        $result=$Response->Query($RequestBuilder);
        return $result;
    }
}