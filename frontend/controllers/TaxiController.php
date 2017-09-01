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

class TaxiController extends Controller
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
        $id = Tools::getParam('id');
        $skuid = Tools::getParam('skuid');
        $url = 'http://thirdapiwaimai-test.meituan.com/api/v1/order/preview';
        $appid = 232;
        $skey="7b441f8967a5e82d1fd4d6b201a9a4ad";
        $params =[];
        $timestamp = time();
        $params['user_phone'] = '13391135289';
        $params['timestamp']=$timestamp;
        $params['app_id']=$appid;
        $wm_ordering_list =[
            'wm_poi_id'=>$id,
            'delivery_time'=>0,
            'pay_type'=>1,
            'food_list'=>[
                ' wm_food_sku_id'=>$skuid,
                'count'=>1,
            ]
        ];
        $params['wm_ordering_list']=json_encode($wm_ordering_list,JSON_UNESCAPED_UNICODE);
        $wm_ordering_user =[

        ];
        $params['wm_ordering_user']=json_encode($wm_ordering_user,JSON_UNESCAPED_UNICODE);

        $sig = $this->genSig($url, $params, $skey);
//        print_r($params);exit;
        $params['sign']=$sig;
        $page = Tools::send_post($url,$params);

        print_r($page);exit;
    }

    public function concatParams($params) {
        ksort($params);
        $pairs = array();
        foreach($params as $key=>$val) {
            array_push($pairs, $key . '=' . $val);
        }
        return join('&', $pairs);
    }

    public function genSig($pathUrl, $params, $consumerSecret) {
        $params = $this->concatParams($params);
        $str = $pathUrl.'?'.$params.$consumerSecret;
        return md5($str);
        //return sha1(bin2hex($str));
    }
}