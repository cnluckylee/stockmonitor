<?php
namespace yii\wxpay\lib;
/**
 * 
 * 微信支付API异常类
 * @author widyhu
 *
 */
use Yii;
use Yii\base\Exception;

class WxPayException {

    public static function showmsg($msg)
    {
        echo $msg;exit;
    }

    public function errorMessage()
	{
		return $this->getMessage();
	}
}
