<?php
/**
 * Created by PhpStorm.
 * User: living
 * Date: 2018/2/28
 * Time: 下午3:24
 */

namespace frontend\controllers;
use Yii;
use yii\web\Controller;

use common\models\Tools;

class GjsController extends Controller
{
    /**
     * 贵金属实时价格
     */
    public function actionTimely()
    {
        header("Content-type: text/html; charset=gb2312");
        $url = 'https://mybank.icbc.com.cn/servlet/AsynGetDataServlet';
        $params = [
            'Area_code'=>1001,
            'trademode'=>1,
            'proIdsIn'=>'',
            'isFirstTime'=>1,
            'tranCode'=>'A00462'
        ];
        $page = Tools::send_post($url,$params);

        print_r($page);exit;
    }
}