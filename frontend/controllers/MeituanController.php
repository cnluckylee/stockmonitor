<?php
/**
 * Created by PhpStorm.
 * User: living
 * Date: 2017/8/30
 * Time: 上午11:31
 */

namespace frontend\controllers;


use common\models\Tools;
use yii\web\Controller;

class MeituanController extends Controller
{

    public function actionFilter()
    {
        $url = 'http://thirdapiwaimai-test.meituan.com/api/v1/poi/filter';
        $appid = 232;
        $skey="7b441f8967a5e82d1fd4d6b201a9a4ad";
        $params =[];
        $timestamp = time();
        $params['timestamp']=$timestamp;
        $params['app_id']=$appid;
        $params['longitude']=121449219;
        $params['latitude']=31237233;

        $sig = $this->genSig($url, $params, $skey);
        $params['sign']=$sig;

        $url  = $url.'?'.http_build_query($params);
        $page = file_get_contents($url);

        print_r($page);exit;
    }

    public function actionFood()
    {
        $id = Tools::getParam('id');
        $url = 'http://thirdapiwaimai-test.meituan.com/api/v1/poi/food';
        $appid = 232;
        $skey="7b441f8967a5e82d1fd4d6b201a9a4ad";
        $params =[];
        $timestamp = time();
        $params['timestamp']=$timestamp;
        $params['app_id']=$appid;
        $params['longitude']=121449219;
        $params['latitude']=31237233;
//        $params['keyword']="KFC";
//        $params['sortType']=1;
        $params['wm_poi_id']=$id;
        $sig = $this->genSig($url, $params, $skey);
        $params['sign']=$sig;

        $url  = $url.'?'.http_build_query($params);
//        $pages = Tools::remote($url,null,false);
        $page = file_get_contents($url);

        print_r($page);exit;
    }

    public function actionPreview()
    {
        $id = Tools::getParam('id',602528);
        $skuid = Tools::getParam('skuid',10327805);
        $timestamp = time();
        $timestamp -=40;
//        $timestamp =         1504510793;
        $url = 'http://thirdapiwaimai-test.meituan.com/api/v1/order/preview';
        $appid = 232;
        $skey="7b441f8967a5e82d1fd4d6b201a9a4ad";
        $params = $locparams = [];

        $locparams['timestamp']=$timestamp;
        $locparams['sign']= '';
        $locparams['app_id']=$appid;
        $food_list = [[
            'wm_food_sku_id'=>$skuid,
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
//            'house_number'=>'',
//            'user_caution'=>'',
//            'user_invoice'=>'',
//            'poilist_latitude'=>'',
//            'poilist_longitude'=>'',
//            'user_latitude'=>'',
//            'user_longitude'=>'',
//            'addr_latitude'=>'',
//            'addr_longitude'=>'',
//            'device_uuid'=>'adsafasdfsdfsfsfdsf',
//            'client_type'=>42,
//            'app_version'=>'1.0.0',
//            'ip'=>'54.78.125.68'
        ];
        $params['wm_ordering_user']=$wm_ordering_user;
//        $wm_ordering_addition =['need_check_shipping_area'=>0];
//        $params['wm_ordering_addition'] = $wm_ordering_addition;
//        $paramss =[
//
//        ];
        $locparams['payload'] = json_encode($params);
        $sig = $this->genSig($url,$locparams,$skey);
        $locparams['sign']=$sig;
        $page = $this->send($url,$locparams);
        print_r($page);exit;
    }

    public function concatParams($params) {
        ksort($params);
        $pairs = array();
        foreach($params as $key=>$val) {
            if(is_array($val))
                $val = json_encode($val);
            if($key !="sign")
                array_push($pairs, $key . '=' . $val);
        }
        return join('&', $pairs);
    }

    public function genSig($pathUrl, $params, $consumerSecret) {
        if($params)
            $params = $this->concatParams($params);
        $str = $pathUrl.'?'.$params.$consumerSecret;
        return md5($str);
    }

    function send($url,$param,$post_file = false)
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
            $aPOST =[];
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
        return $sContent;
    }

    public function actionT()
    {
        $url = 'http://sandbox.open.yongche.org/v2/cost/estimated';
        $params = array(
            'access_token'=>'WUjYEYqBO4Mb1ulVGYFBnvrBY6O8XDV51QY0WR4O',
            'city'=>'bj',
            'type' => 7,
            'aircode'=>'PEK', //接送机必填
            'car_type_id' => 2,
            'expect_start_latitude' => '39.955538',
            'expect_start_longitude' => '116.458637',
            'expect_end_latitude' => '39.911093',
            'expect_end_longitude' => '116.373055',
            'time' => '2017-09-19 11:22:33',
//            'rent_time' => 2,
            'map_type' => 2
        );
        $page = Tools::send_post($url,$params);
//        $page = json_decode($page,true);
        print_r($page);exit;

    }

    public function actionO()
    {
        $url = 'http://sandbox.open.yongche.org/v2/order?access_token=WUjYEYqBO4Mb1ulVGYFBnvrBY6O8XDV51QY0WR4O';
        $params = array(
            'city'=>'bj',
            'type' => 7,
            'aircode'=>'PEK', //接送机必填 'car_type_id' => 2,
            'start_position' => '颐和园',
            'expect_start_latitude' => '39.955538',
            'expect_start_longitude' => '116.458637',
            'time' => date('Y-m-d H:i:s',strtotime('+2 hour')),
            'rent_time' => 2,
            'end_position' => '总部基地',
            'expect_end_latitude' => '39.911093',
            'expect_end_longitude' => '116.373055',
            'passenger_name' => 'test',
            'passenger_phone' => '13391135289', 'invoice' => 1,
            'car_type_id'=>2,
            'receipt_title' => '111111111', 'receipt_content' => '22222222', 'address' => '3333333',
            'postcode' => '100000',
            'sms_type' => 1, //给乘车人发短信 'msg'=>'111111111111',
            'app_trade_no' => 'ceshi'.date('YmdHis'),
            'access_token' => 'WUjYEYqBO4Mb1ulVGYFBnvrBY6O8XDV51QY0WR4O'
        );
        $page = Tools::send_post($url,$params);
        print_r($page);exit;
    }
}