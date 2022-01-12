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
                'user/approval/<type:\w+>/<id:\d+>' => 'user/approval',
                'user/update/<id:\d+>' => 'user/update',
                'post/update/<postId:\d+>' => 'post/update',
                'api/post/update/<postId:\d+>' => 'api/posts/update',
                'file/view/<assetId:\d+>' => 'files/view',
                'api/post/trash-element' => 'api/posts/trash-element',
                'api/post/get-post/<postId:\d+>' => 'api/posts/get-post',
                'post/trash/<postId:\d+>' => 'post/trash/',
                'site' => 'site/index',
                'post/<postId:\d+>' => 'site/post',
                'site/about' => 'site/about',
                'site/login' => 'site/login',
                'site/register' => 'site/register'
            ]
        ],
        'user' => [
            'identityClass' => bb\models\UserModel::class,
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
    'defaultRoute' => 'site'
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
