<?php

$vendorDir = dirname(__DIR__);

return array (
  'yiisoft/yii2-swiftmailer' =>
  array (
    'name' => 'yiisoft/yii2-swiftmailer',
    'version' => '2.0.0.0',
    'alias' =>
    array (
      '@yii/swiftmailer' => $vendorDir . '/yiisoft/yii2-swiftmailer',
    ),
  ),

  'yiisoft/yii2-mongodb' =>
    array (
        'name' => 'yiisoft/yii2-mongodb',
        'version' => '2.0.0.0',
        'alias' =>
            array (
                '@yii/mongodb' => $vendorDir . '/yiisoft/yii2-mongodb',
            ),
    ),
  'yiisoft/yii2-redis' =>
    array (
        'name' => 'yiisoft/yii2-redis',
        'version' => '2.0.0.0',
        'alias' =>
            array (
                '@yii/redis' => $vendorDir . '/yiisoft/yii2-redis',
            ),
  ),
  'yiisoft/yii2-bootstrap' =>
  array (
    'name' => 'yiisoft/yii2-bootstrap',
    'version' => '2.0.0.0',
    'alias' =>
    array (
      '@yii/bootstrap' => $vendorDir . '/yiisoft/yii2-bootstrap',
    ),
  ),


  'yiisoft/yii2-gii' =>
  array (
    'name' => 'yiisoft/yii2-gii',
    'version' => '2.0.0.0',
    'alias' =>
    array (
      '@yii/gii' => $vendorDir . '/yiisoft/yii2-gii',
    ),
  ),

);
