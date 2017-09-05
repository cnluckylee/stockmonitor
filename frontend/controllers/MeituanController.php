<?php
/**
 * Created by PhpStorm.
 * User: living
 * Date: 2017/9/5
 * Time: 上午10:25
 */

namespace frontend\controllers;


use yii\web\Controller;
use common\models\Tools;

class MeituanController extends Controller
{
    public function actionI()
    {
        $sbmt = new MeituanSDK(232,'7b441f8967a5e82d1fd4d6b201a9a4ad');
        $sbmt->createByShop([]);
    }
}


class MeituanSDK
{
    private $URL = 'http://thirdapiwaimai-test.meituan.com';
    private $APP_KEY = '232';
    private $APP_SECRET = '7b441f8967a5e82d1fd4d6b201a9a4ad';
    private $VERSION = '1.0';
    private $API_CREATE = '/order/createByShop';
    private $API_DELETE = '/order/delete';
    private $API_QUERY = '/order/status/query';
    private $API_ARRANGE = '/test/order/arrange';
    private $API_PICKUP = '/test/order/pickup';
    private $API_DELIVER = '/test/order/deliver';
    private $API_REARRANGE = '/test/order/rearrange';
    private $API_PREVIEW = '/api/v1/order/preview';
    public function __construct($appkey, $appsec)
    {
//        parent::__construct();
        $this->APP_KEY = $appkey;
        $this->APP_SECRET = $appsec;
    }



    /**
     * 新增订单
     * @return bool
     */
    public function createByShop($data=[])
    {
        $id = Tools::getParam('id');
        $skuid = Tools::getParam('skuid');
        $timestamp = time();
        $timestamp -=40;
//        $timestamp =         1504510793;

        $appid = 232;

        $params = $locparams = [];

        $locparams['timestamp']=$timestamp;
        $locparams['sign']= '';
        $locparams['app_id']=$appid;
        $food_list = [[
            ' wm_food_sku_id'=>$skuid,
            'count'=>1,
        ]];
        $wm_ordering_list =[
            'wm_poi_id'=>$id,
            'delivery_time'=>0,
            'pay_type'=>1,
            'food_list'=> $food_list

        ];
        $params['wm_ordering_list']=$wm_ordering_list;
        $wm_ordering_user =[
            'user_phone'=>'',
            'user_name'=>'',
            'user_address'=>'',
        ];
        $params['wm_ordering_user']=$wm_ordering_user;

        $locparams['payload'] = json_encode($params);
        $sig = $this->sign($locparams,$timestamp);
        $locparams['sign']=$sig;
        $page = self::getResult($this->API_PREVIEW, $locparams);
        print_r($page);exit;
    }
    /**
     * 取消订单
     * @param array $data
     * @return bool
     */
    public function delete($data)
    {
//        $data['delivery_id'] = 6652266937;
//        $data['mt_peisong_id'] = 1501205493087417;
//        $data['cancel_reason'] = "其他原因";
        return self::getResult($this->API_DELETE, $data);
    }
    /**
     * 查询订单
     * @param array $data
     * @return bool
     */
    public function query($data)
    {
        // $data['delivery_id'] = 9099431186;
        // $data['mt_peisong_id'] = 1501052461078366;
        return self::getResult($this->API_QUERY, $data);
    }
    /**
     * 接单（仅测试模式可用）
     * @param array $data
     * @return bool
     */
    public function arrange($data)
    {
        // $data['delivery_id'] = 9099497547;
        // $data['mt_peisong_id'] = 1501041683089449;
        return self::getResult($this->API_ARRANGE, $data);
    }
    /**
     * 取货（仅测试模式可用）
     * @param array $data
     * @return bool
     */
    public function pickUp($data)
    {
        // $data['delivery_id'] = 9223372036854775807;
        // $data['mt_peisong_id'] = 1500533369085204;
        return self::getResult($this->API_PICKUP, $data);
    }
    /**
     * 送达（仅测试模式可用）
     * @param array $data
     * @return bool
     */
    public function deliver($data)
    {
        // $data['delivery_id'] = 7754660177546601;
        // $data['mt_peisong_id'] = 1500102509083591;
        return self::getResult($this->API_DELIVER, $data);
    }
    /**
     * 改派（仅测试模式可用）
     * @param array $data
     * @return bool
     */
    public function rearrange($data)
    {
        // $data['delivery_id'] = 7754660177546601;
        // $data['mt_peisong_id'] = 1500102509083591;
        return self::getResult($this->API_REARRANGE, $data);
    }
    /**
     * 根据参数获取结果信息
     * @param $api
     * @param $data
     * @return bool
     */
    public function getResult($api, $data = '')
    {
        $param = self::getParam($data);
        $url = $this->URL . $api;
        $res = self::http_post($url, $param);
        if ($res) {
            $res = json_decode($res, true);
            return $res;
        }
        return false;
    }
    /**
     * 整合参数格式
     * @param array $param
     * @return array
     */
    private function getParam($param)
    {
        $time = time();
        $sign = self::sign($param, $time);
        $tmpArr = array(
            "appkey" => $this->APP_KEY,
            "timestamp" => $time,
            "version" => $this->VERSION,
            "sign" => $sign
        );
        foreach ($param as $k => $v)
            $tmpArr[$k] = $v;
        return $tmpArr;
    }
    /**
     * 签名
     * @param array $param
     * @param int $time
     * @return string
     */
    private function sign($param, $time)
    {
        $tmpArr = array(
            "appkey" => $this->APP_KEY,
            "timestamp" => $time,
            "version" => $this->VERSION,
        );
        foreach ($param as $k => $v)
            $tmpArr[$k] = $v;
        ksort($tmpArr);
        $str = $this->APP_SECRET;
        foreach ($tmpArr as $k => $v) {
            if ($v === false)
                $v = 'false';
            if ($v === true)
                $v = 'true';
            if (empty($v) && $v != 0)
                continue;
            $str .= $k . $v;
        }
        $signature = sha1($str);
        return strtolower($signature);
    }
    /**
     * POST 请求
     * @param string $url
     * @param array $param
     * @param boolean $post_file 是否文件上传
     * @return string content
     */
    private function http_post($url, $param, $post_file = false)
    {
        $oCurl = curl_init();
        if (stripos($url, "https://") !== FALSE) {
            curl_setopt($oCurl, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($oCurl, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($oCurl, CURLOPT_SSLVERSION, 1); //CURL_SSLVERSION_TLSv1
        }
        if (is_string($param) || $post_file) {
            $strPOST = $param;
        } else {
            $aPOST;
            foreach ($param as $key => $val) {
                $aPOST[] = $key . "=" . urlencode($val);
            }
            $strPOST = join("&", $aPOST);
        }
        curl_setopt($oCurl, CURLOPT_URL, $url);
        curl_setopt($oCurl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($oCurl, CURLOPT_POST, true);
        curl_setopt($oCurl, CURLOPT_POSTFIELDS, $strPOST);
        $header = array(
            'application/x-www-form-urlencoded',
        );
        curl_setopt($oCurl, CURLOPT_HTTPHEADER, $header);
        $sContent = curl_exec($oCurl);
        $aStatus = curl_getinfo($oCurl);
        curl_close($oCurl);
        if (intval($aStatus["http_code"]) == 200) {
            return $sContent;
        } else {
            return false;
        }
    }
}