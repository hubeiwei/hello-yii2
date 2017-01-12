<?php
return [
    'request' => [
        'cookieValidationKey' => '5OhTzH5Cw07lUaWxu6_sixbCsKj77-g-',
    ],
    'urlManager' => [
        'enablePrettyUrl' => true,
        'showScriptName' => false,
        'rules' => [
            'login' => '/user/default/login',
            'logout' => '/user/default/logout',
            'register' => '/user/default/register',
        ],
    ],
    'errorHandler' => [
        'errorAction' => '/site/error',
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
    'cache' => [
        'class' => 'yii\caching\FileCache',
    ],
    'user' => [
        'enableAutoLogin' => true,
        'identityClass' => 'app\models\User',
        'loginUrl' => ['/login'],
    ],
    'authManager' => [
        'class' => 'yii\rbac\DbManager',
        'defaultRoles' => ['Guest'],
    ],
    'formatter' => [
        'dateFormat' => 'php:Y-m-d',
        'datetimeFormat' => 'php:Y-m-d H:i:s',
    ],
    'assetManager' => [
        'bundles' => [
            'app\assets\HighlightAsset' => [
                'css' => ['styles/solarized-light.css'],
            ],
        ]
    ],
    // TODO 在以下修改好自己的邮箱配置，才可以使用邮件找回密码的功能
    'mailer' => [
        'class' => 'yii\swiftmailer\Mailer',
        'useFileTransport' => false,
        'transport' => [
            'class' => 'Swift_SmtpTransport',
            'host' => 'smtp.163.com',
            'port' => '25',
            'username' => '',
            'password' => '',
            'encryption' => 'tls',
        ],
        'messageConfig' => [
            'charset' => 'UTF-8',
            // 这里是发件人名称
            'from' => [
                'hubeiwei1234@163.com' => 'Hello yii2 robot',
            ],
        ],
    ],
];
