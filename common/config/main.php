<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'bootstrap' => ['log'],
    'components' => [
        //日志配置
        'log' => [
            'flushInterval' => 1000,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['info'],
                    'logVars' => ['_POST'],
                    'categories' => ['know_you_info'],
                    'logFile' => '@root/log/know_you/know_you_info.log',
                    'exportInterval' => 100,
                ],
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['warning'],
                    'logVars' => ['_POST'],
                    'categories' => ['know_you_warn'],
                    'logFile' => '@root/log/know_you/know_you_warn.log',
                    'exportInterval' => 10,
                ],
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error'],
                    'logVars' => ['*'],
                    'categories' => ['know_you_error'],
                    'logFile' => '@root/log/know_you/know_you_error.log',
                    'exportInterval' => 1,
                ],
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['info', 'warning', 'error'],
                    'logVars' => ['*'],
                    'categories' => ['know_you_console'],
                    'logFile' => '@root/log/know_you/know_you_console.log',
                    'exportInterval' => 100,
                ]
            ]
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'session' => [
            'timeout' => 7200,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ]
        //URL配置
        /*
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => false,
            'rules' => [
                '<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
            ]
        ],
        */
    ],
];
