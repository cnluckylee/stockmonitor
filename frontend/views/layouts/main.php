<?php
use yii\helpers\Html;
?>
<?php $this->beginPage() ?>
<!DOCTYPE HTML>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <title><?= Html::encode($this->title) ?></title>
    <meta name="viewport" content="maximum-scale=1.0,minimum-scale=1.0,user-scalable=0,width=device-width,initial-scale=1.0"/>
    <meta name="format-detection" content="telephone=no,email=no,date=no,aItemress=no">
    <meta name="description" content="<?=Yii::$app->params['description']?>">
    <meta itemprop="name" content="<?=Yii::$app->params['name']?>">
    <meta itemprop="image" content="<?=Yii::$app->params['cdn_website'].Yii::$app->params['image']?>">
    <meta name="keywords" content="图片,图片分享,Spotter">
    <meta name="msapplication-tap-highlight" content="no">
    <meta name="screen-orientation"content="portrait">
    <meta name="x5-orientation" content="portrait">
    <?= Html::csrfMetaTags() ?>
    <link rel="stylesheet" type="text/css" href="/themes/aui/css/aui.css" />
    <link rel="stylesheet" type="text/css" href="/themes/frozen/css/frozen.css?v=2" />
    <script type="text/javascript" src="/themes/frozen/js/zepto.min.js?v=2"></script>
</head>
<style>
    body{
        -webkit-touch-callout: none;
        -webkit-user-select: none;
        -khtml-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }
</style>
<body>
<?= $content ?>
</body>
</html>
