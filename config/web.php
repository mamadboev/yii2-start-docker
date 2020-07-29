<?php

use yii\base\BaseObject;
use yii\helpers\ArrayHelper as ArrayHelperAlias;

$params = ArrayHelperAlias::merge(
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

$db = ArrayHelperAlias::merge(
    require __DIR__ . '/db.php',
    require __DIR__ . '/db-local.php'
) ;


$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'request' => [
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ],
            'cookieValidationKey' => '01531c336e3c569cb14353e8f9fdd1e5b47f7931',
        ],

        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => app\modules\api\models\User::class
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,

        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        'response' => [
                   'class' => yii\web\Response::class,
                   'on beforeSend' => function ($event) {
                                 $response = $event->sender;
                                 if ($response->data !== null ) {
                        $response->data = array(
                        'success' => $response->isSuccessful,
                        'data' =>  $response->isSuccessful ? $response->data : new BaseObject(),
                        'error'=> $response->isSuccessful ? new BaseObject() : array(
                            'code'=> $response->data['status'] ?? 0,
                            'message' => $response->data['message'] ?? "unknown error",
                        )
                        );
                    $response->statusCode = 200;
                }
            },
        ]

    ],
    'modules' => [
        'api' => [
            'class' => 'app\modules\api\Module',
        ],
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
