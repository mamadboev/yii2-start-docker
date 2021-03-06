<?php
use yii\console\controllers\MigrateController;
use yii\helpers\ArrayHelper as ArrayHelperAlias;

$params = ArrayHelperAlias::merge(
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

$db = ArrayHelperAlias::merge(
    require __DIR__ . '/db.php',
    require __DIR__ . '/db-local.php'
);

$config = [
    'id' => 'basic-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'app\commands',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
        '@tests' => '@app/tests',
    ],
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,
    ],
    'params' => $params,

    'controllerMap' => [
        'migrate'=>[
          'class' => MigrateController::class,
          'migrationPath' =>[
             // '@app/migrations',
              '@app/modules/api/migrations',
          ]
        ],
        'fixture' => [ // Fixture generation command line.
            'class' => 'yii\faker\FixtureController',
        ],
    ],

];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
