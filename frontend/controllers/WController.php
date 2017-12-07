<?php
namespace frontend\controllers;
use Yii;
use yii\web\Controller;
use common\models\Tools;

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
        $str = '[
{"id":"1","fShopID":"f00102135","fTitle":"仙美 山东烟台红灯大樱桃 新鲜国产车厘子 2.5kg 中果 果径20mm-25mm 自营水果","fImg":"./list/img/pic4.png","fPrice":"21","fPostage":"免邮费","fRecord":"236"},
{"id":"2","fShopID":"f00102135","fTitle":"玛玛绨新款条纹印花半身裙女2016春欧美修身时尚潮牌一步裙包臀裙","fImg":"./list/img/pic2.png","fPrice":"115","fPostage":"免邮费","fRecord":"62"},
{"id":"3","fShopID":"f00105411","fTitle":"都市白领 修身舒适 时尚大方 精品男士Polo衫","fImg":"./list/img/pic1.png","fPrice":"90","fPostage":"免邮费","fRecord":"66"},
{"id":"4","fShopID":"f00105411","fTitle":"时尚真皮女凉鞋 牛筋底中跟欧美潮鞋 2015夏个性森系女鞋子罗马鞋","fImg":"./list/img/pic6.png","fPrice":"219","fPostage":"免邮费","fRecord":"3"},
{"id":"5","fShopID":"f00105411","fTitle":"左街右巷 潮牌牛仔 破洞时尚 修身百搭 浅蓝色青年良品","fImg":"./list/img/pic3.png","fPrice":"320","fPostage":"免邮费","fRecord":"14"},
{"id":"6","fShopID":"f00105411","fTitle":"雪纺印花百褶裙半身裙,简约的线条和版型上身很好看，整体更有看点。","fImg":"./list/img/pic7.png","fPrice":"115","fPostage":"免邮费","fRecord":"62"},
{"id":"7","fShopID":"f00102135","fTitle":"满足你对美的追求，触动内心的惊喜与感动。纵然时光流转，美的信念从未改变","fImg":"./list/img/pic5.png","fPrice":"219","fPostage":"免邮费","fRecord":"3"},
{"id":"8","fShopID":"f00102135","fTitle":"轻松百搭，时尚魅力   整个鞋款轻盈优雅大方，无论是裙装还是裤装，参加party还是约会，都能让你轻松驾驭","fImg":"./list/img/pic6.png","fPrice":"320","fPostage":"免邮费","fRecord":"14"},
{"id":"9","fShopID":"f00101621","fTitle":"2016夏林允唐嫣明星街拍同款蓝色衬衫+网格镂空半身裙两件套装","fImg":"./list/img/pic7.png","fPrice":"90","fPostage":"免邮费","fRecord":"66"},
{"id":"10","fShopID":"f00101621","fTitle":"左街右巷 潮牌牛仔 破洞时尚 修身百搭 浅蓝色青年良品","fImg":"./list/img/pic3.png","fPrice":"21","fPostage":"免邮费","fRecord":"236"}
]';
        $d = json_decode($str,true);
        $out = [
            'errno' =>0,
            'list' =>$d
        ];
        Tools::jsonOut($out);
    }
}
