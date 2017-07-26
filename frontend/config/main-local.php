<?php
return [
    'components' => [
        'mongodb' => [
            'class' => '\yii\mongodb\Connection',
            'dsn' => 'mongodb://10.0.0.2:19879/jubi',
        ],
        'redis' => [
            'class' => 'yii\redis\Connection',
            'hostname' => '10.0.0.2',
            'port' => 19889,
            'database' => 1,
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'useFileTransport' =>false,//这句一定有，false发送邮件，true只是生成邮件在runtime文件夹下，不发邮件
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.163.com',  //每种邮箱的host配置不一样
                'username' => 'woyaotixing@163.com',
                'password' => 'qaZXsw21',
                'port' => '25',
                'encryption' => 'tls',

            ],
            'messageConfig'=>[
                'charset'=>'UTF-8',
                'from'=>['woyaotixing@163.com'=>'我要提醒']
            ],

        ],
    ],
];
