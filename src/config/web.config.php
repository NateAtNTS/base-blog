<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'base-blog-web',
    'name' => "Base Blog Web",
    'version' => '0.1',
    'basePath' => dirname(__DIR__),
    'class' => bb\web\Application::class,
    'bootstrap' => ['log'],
    'controllerNamespace' => 'bb\controllers',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'request' => [
            'class' => bb\web\Request::class,
            'enableCookieValidation' => false,
            'enableCsrfValidation' => false,
        ],
        'urlManager' => [
            'class' => yii\web\UrlManager::class,
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'ruleConfig' => [
                'class' => yii\web\UrlRule::class
            ],
            'rules' => [
                'api/<controller>/<action>/<id:\d+>' => 'api/<controller>/<action>',
                'user/profile' => 'users/profile',
                'user/check-username' => 'users/check-username',
            ]
        ],
        'user' => [
            'identityClass' => bb\models\User::class,
            'enableSession' => false,
            'loginUrl' => null,
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
    ],
    'params' => $params,
    'defaultRoute' => 'hello/index'
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => yii\debug\Module::class
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];

}

return $config;
