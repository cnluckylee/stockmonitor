<?php
return [
    'components' => [
        'mongodb' => [
            'class' => '\yii\mongodb\Connection',
            'dsn' => 'mongodb://alialpha:19879/jubi',
        ],
        'redis' => [
            'class' => 'yii\redis\Connection',
            'hostname' => 'alialpha',
            'port' => 19889,
            'database' => 1,
        ],
    ],
];
