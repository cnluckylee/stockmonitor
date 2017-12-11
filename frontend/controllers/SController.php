<?php
namespace frontend\controllers;
use Yii;
use yii\web\Controller;
use common\models\Tools;

/**
 * Site controller
 */
class SController extends Controller
{
    public function actionIndex()
    {
        echo "相信这是一个美好的开始！";exit;
    }

    public function actionList()
    {
      $url = 'http://quotes.money.163.com/hs/service/diyrank.php?query=STYPE:EQA&fields=NO,SYMBOL,name,PRICE,PERCENT,UPDOWN,OPEN,YESTCLOSE,HIGH,LOW,VOLUME,TURNOVER,HS,LB,WB,ZF,PE,MCAP,TCAP,MFSUM,MFRATIO.MFRATIO2,MFRATIO.MFRATIO10,SNAME,CODE,ANNOUNMT,UVSNEWS&order=desc&type=query';
      $params = [
        'page'=>1,
          'count'=>100
      ];
      $page = Tools::getUrl($url,$params);
      $datas = json_decode($page,true);
      $pagecount = $datas['pagecount'];
      for($i=1;$i<$pagecount;$i=$i+1)
      {

              $params = [
                'page'=>$i,
                  'count'=>100
              ];
              $page = Tools::getUrl($url,$params);
              $datas = json_decode($page,true);
             $lists = $datas['list'];
             if($lists)
             {
                 $d = [];
                 foreach($lists as $k=>$v)
                 {
                     foreach($v as $kk=>$vv)
                     {
                         $d[strtolower($kk)] = $vv;
                     }
                     print_r($d);exit;
                 }
             }

      }
      print_r($page);exit;
    }
}
