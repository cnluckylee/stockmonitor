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
  'yiisoft/yii2-codeception' =>
  array (
    'name' => 'yiisoft/yii2-codeception',
    'version' => '2.0.0.0',
    'alias' =>
    array (
      '@yii/codeception' => $vendorDir . '/yiisoft/yii2-codeception',
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
  'yiisoft/yii2-debug' =>
  array (
    'name' => 'yiisoft/yii2-debug',
    'version' => '2.0.0.0',
    'alias' =>
    array (
      '@yii/debug' => $vendorDir . '/yiisoft/yii2-debug',
    ),
  ),
  'yiisoft/yii2-faker' =>
  array (
    'name' => 'yiisoft/yii2-faker',
    'version' => '2.0.0.0',
    'alias' =>
    array (
      '@yii/faker' => $vendorDir . '/yiisoft/yii2-faker',
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


//    'yiisoft/yii2-authclient' =>
//    array (
//        'name' => 'yiisoft/yii2-authclient',
//        'version' => '2.0.0.0',
//        'alias' =>
//            array (
//                '@yii/gii' => $vendorDir . '/yiisoft/yii2-authclient',
//            ),
// ),
//    'yiisoft/yii2-httpclient' =>
//        array (
//            'name' => 'yiisoft/yii2-httpclient',
//            'version' => '2.0.0.0',
//            'alias' =>
//                array (
//                    '@yii/gii' => $vendorDir . '/yiisoft/yii2-httpclient',
//                ),
//        ),

  '2amigos/yii2-qrcode-helper' =>
  array (
    'name' => '2amigos/yii2-qrcode-helper',
    'version' => '1.0.2.0',
    'alias' =>
    array (
      '@dosamigos/qrcode' => $vendorDir . '/2amigos2/yii2-qrcode-helper/src',
    ),
  ),

    'yii/yii2-alipay' =>
        array (
            'name' => 'yii/yii2-alipay',
            'version' => '2.0.0.0',
            'alias' =>
                array (
                    '@yii/alipay' => $vendorDir . '/yiisoft/yii2-alipay',
                ),
        ),

    'yii/yii2-wxpay' =>
        array (
            'name' => 'yii/yii2-wxpay',
            'version' => '2.0.0.0',
            'alias' =>
                array (
                    '@yii/wxpay' => $vendorDir . '/yiisoft/yii2-wxpay',
                ),
        ),
);
