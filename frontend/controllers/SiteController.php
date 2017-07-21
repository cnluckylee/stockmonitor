<?php
namespace frontend\controllers;


use common\models\LUserLogMgt;
use Yii;
use yii\web\Controller;
use dosamigos\qrcode\QrCode;
use common\models\Tools;
use common\models\LSoftUpdateMgt;

/**
 * Site controller
 */
class SiteController extends Controller
{
    public function actionIndex()
    {
        echo "相信这是一个美好的开始！";exit;
    }
}
