<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'myweb',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'defaultRoute'=>'home/index',
    'timeZone'=>'Asia/Chongqing',
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '12345678',
            //'enableCookieValidation' => false,
           // 'enableCsrfValidation' => false,
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',    
            'transport' => [    
                               'class' => 'Swift_SmtpTransport',    
                               'host' => 'smtp.163.com',    
                               'username' => 'zhaolaixi168@163.com',    
                               'password' => 'dhybvtciaayucnyb',    
                               'port' => '25',    
                               'encryption' => 'tls',    
                                     
                           ],     
            'messageConfig'=>[    
               'charset'=>'UTF-8',    
               'from'=>['zhaolaixi168@163.com'=>'Webmaster']    
               ],    
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['info'],
                    'categories' => ['Notify'],
                       'logVars'=>['$_POST'],
                    'logFile' => '@app/runtime/logs/'.date('Y-m-d').'.info.log',
               ],
               [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error'],
                    'categories' => ['Error'],
                    'logVars'=>['$_POST'],
                    'logFile' => '@app/runtime/logs/'.date('Y-m-d').'.error.log',
               ],       
            ],
        ],
        'db' => require(__DIR__ . '/db.php'),
        /*
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        */
    ],
    'aliases' => [ 
        '@resource' => '/yii2/resource/', 
    ], 
    'modules' => [
         'admin' => [
            'class' => 'app\modules\admin\Admin', 
         ],
         'home' => [
            'class' => 'app\modules\home\Home',
        ],
        'api' => [
            'class' => 'app\modules\api\Api',
        ],
      ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        'allowedIPs' => ['127.0.0.1','::1'], 
    ];
}

return $config;
