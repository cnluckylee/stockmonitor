<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class SiteAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/bootstrap.min.css?v=2.0',
//        'css/jasny-bootstrap.min.css',
//        'css/pe-icon-set-location.css',
//        'css/pe-icon-set-social-people.css',
//        'css/helper.css',
//        'css/jquery.fullPage.css',
        'css/styles.css?v=2.0',
        'css/swiper.min.css?v=2.0'
    ];

    public $js = [
        'js/bootstrap.min.js?v=2.0',

//        'js/jasny-bootstrap.min.js',
//        'js/main.js',
//        'js/jquery.fullPage.min.js',
//        'js/fullpage-custom.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
