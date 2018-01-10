<?php
/**
 * Created by PhpStorm.
 * User: living
 * Date: 2017/12/11
 * Time: 下午2:38
 */
namespace frontend\models;
use Yii;
use yii\base\Model;
use common\models\Tools;

/**
 * ContactForm is the model behind the contact form.
 */
class StockMgt extends Model
{
    public static function queryCode($keyword)
    {
        $url = 'http://quotes.money.163.com/stocksearch/json.do';
        $params = [
            'type'=>'',
            'count'=>5,
            'word'=>$keyword
        ];
        $page = Tools::getUrl($url,$params);
        $pageArray = self::formatData($page);
        return $pageArray;
    }


    public static function getList($codes)
    {
        if(is_array($codes)){
            foreach($codes as $k=>$v)
            {
                $codes[$k] = self::formatCode($v);
            }
            $str_code = implode(",",$codes);
        }else
            $str_code = self::formatCode($codes);

        $url ='http://api.money.126.net/data/feed/'.$str_code.',money.api?callback=ntes_stocksearch_callback';
        $page = Tools::getUrl($url);
        $pageArray = self::formatData($page);
        $datas =[];
        foreach($pageArray as $k=>$v) {
            $data = [
                'code' => $v['symbol'],
                'name' => $v['name'],
                'updown' => $v['updown'],
                'type' => strtolower($v['type']),
                'price' => $v['price']
            ];
            $datas [] = $data;
        }
        return $datas;
    }


    public static function formatData($str)
    {
        $preg = '/ntes_stocksearch_callback\((.*)\)/iUs';
        preg_match($preg,$str,$out);
        $data = isset($out[1])?$out[1]:'';
        return json_decode($data,true);
    }

    public static function formatCode($code,$op = 1)
    {
        if($op == 1)
        {
            if(substr($code,0,1) == 0)
                return '1'.$code;
            else{
                return '0'.$code;
            }
        }else{
            return substr($code,1);
        }
    }
}