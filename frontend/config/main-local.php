<?php
return [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=www.dhhtrade.com;dbname=ocean',
            'username' => 'wayne',
            'password' => 'jiang1221',
            'charset' => 'utf8mb4',
            'tablePrefix'=>'OC_',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            'useFileTransport' => true,
        ],
    ],
];
