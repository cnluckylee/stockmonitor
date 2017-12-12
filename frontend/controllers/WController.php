<?php
namespace frontend\controllers;
use Yii;
use yii\web\Controller;
use common\models\Tools;
use frontend\models\Stock;

/**
 * Site controller
 */
class WController extends Controller
{
    public function actionIndex()
    {
        echo "相信这是一个美好的开始！";exit;
    }

    public function actionList()
    {
        $params = [
            '600782','600917','000670','000725','600677','002600'
        ];
        $d = Stock::getList($params);
        $out = [
            'errno'=>0,
            'list'=>$d
        ];
        Tools::jsonOut($out);
    }

    public function actionQuerycode()
    {
        $keyword = Tools::getParam('keyword');
        $data = Stock::queryCode($keyword);
        Tools::jsonOut($data);
    }
}
