<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/20
 * Time: 7:05
 */

namespace frontend\controllers;
use common\models\Stock;
use Yii;

use yii\db\Exception;
use yii\web\Controller;
use common\models\Tools;

class StockController extends Controller
{
    public function actionAdd()
    {
        $params = [];
        $params['uid'] = 1;
        $params['coin'] = Tools::getParam('coin');
        $params['name'] = Tools::getParam('name');
        $params['count'] = Tools::getParam('count');
        $params['price'] = Tools::getParam('price');
        $params['percent'] = Tools::getParam('percent');
        $params['starttime'] = Tools::getParam('starttime');
        $params['endtime'] = Tools::getParam('endtime');
        $params['state'] = 1;

        $model = new Stock();
        $model->attributes = $params;
        $model->createdtime = date('Y-m-d H:i:s');
        $model->save();
    }

    /**
     * 每个5s执行一次
     */
    public function actionCompare()
    {
        header("Content-type: text/html; charset=utf-8");
        $mongoData = Stock::findAll(['state'=>1]);
        $list = [];
        $stocklists = [];
        $t = time();
        foreach($mongoData as $k=>$v)
        {
            $list[] = $v->coin;

            if(strtotime($v->endtime)>=$t && $t>=strtotime($v->starttime))
            {
                $stocklists[$v->coin] = $v;
            }else{
                $v->updateAttributes(['state'=>2]);
            }
//            Stock::updateAll(['state'=>1],['_id'=>$v->_id]);
        }
        $url = 'http://hq.sinajs.cn/list='.implode(",",$list);
        $page = $this->file_get_contents_utf8($url);
        $preg = '/"(.*)";/';
        preg_match_all($preg,$page,$out);
        if(!isset($out[1]))
            return ;
        $preg_name = '/hq_str_(\w+)=/';
        preg_match_all($preg_name,$page,$out2);
        if(!isset($out2[1]))
            return ;
        $stocks = [];
        foreach($out[1] as $k=>$v)
        {
            $a = explode(",",$v);
            if(count($a)<10)
                continue;
                $code = $out2[1][$k];
                $stocks[$code] = [
                    'code'=>$code,
                    'name'=>$a[0],
                    'kpprice'=>$a[1],
                    'yprice'=>$a[2],
                    'sell'=>$a[3],
                    'time'=>$a[30].' '.$a[31]
                ];
        }
        $redis = Yii::$app->redis;
        $page = $redis->get('jubi:stock');
        $redisData = json_decode($page,true);
        //避免每次都要重新跑一次数据
        $result = [];
        foreach($stocks as $code=>$v)
        {
            $row = isset($redisData[$code])?$redisData[$code]:"";
            $name = $v['name'];
            if(!$row){
                $v['maxsell'] = $v['sell'];
                $v['minsell'] = $v['sell'];
                $result[$code] = $v;
                $row = $v;
            }else{
                if(!isset($row['maxsell'])){
                    $row['maxsell'] = $v['sell'];
                }else if($row['maxsell']<$v['sell'])
                {
                    //保存最高售价
                    $row['maxsell'] = $v['sell'];
                }

                if(!isset($row['minsell']))
                {
                    $row['minsell'] = $v['sell'];
                }else if($row['minsell']>$v['sell']){
                    //保存最低售价
                    $row['minsell'] = $v['sell'];
                }
                $row['updatedtime'] = date('Y-m-d H:i:s');
                $result[$code] = $row;
            }
            $reserve = isset($stocklists[$code])?$stocklists[$code]:"";
            if($reserve)
            {
                $percent = $reserve->percent;
                $type = $reserve->type;
                if($type == 'sell')
                {
                    try{
                        echo $name.' '.$v['sell']/$row['maxsell'] ."<br>";
                        if($v['sell']/$row['maxsell']<$percent)
                        {
                            $count = $reserve->count;
                            $yll = ($v['sell']-$reserve->price)/$reserve->price*100;
                            $yll = number_format($yll,2);
                            $yl = ($v['sell']-$reserve->price)*$count;
                            $body = "数量".$count.',卖出价：'.$v['sell'].'，盈利率：'.$yll.',盈利:'.$yl;
                            $reserve->updateAttributes(['state'=>2]);
                            $this->sendMail($name." 卖出提醒",$body);
                        }
                    }catch(Exception $e)
                    {
                        print_r($e);exit;
                    }

                }else if($type == 'buy')
                {
                    if($row['minsell']*$percent<$v['sell'])
                    {
//                        $count = $reserve->count == 0?Account::getCoinNum(Account::getUid(),$k):$reserve->count;
//                        $this->trade($count,$v['sell']*0.99,'buy',$k,$reserve->_id);
                    }
                }
            }
        }
        $redis->set('jubi:stock',json_encode($result));
    }

    function file_get_contents_utf8($fn) {
        $content = file_get_contents($fn);
        return mb_convert_encoding($content, 'UTF-8',
            mb_detect_encoding($content, 'UTF-8, GB2312', true));
    }

    public function sendMail($subject,$body)
    {
        $mail= Yii::$app->mailer->compose();
        $mail->setTo('living10@126.com');
        $mail->setSubject($subject);
        $body = html_entity_decode($body);
        $mail->setHtmlBody($body);    //发布可以带html标签的文本
        $mail->send();
    }
}