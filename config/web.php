<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'basic',
    'name' => 'Hello Yii2',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'LaoHu',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'enableAutoLogin' => true,
            'identityClass' => 'app\models\User',
            'loginUrl' => ['/login'],
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
                    'css' => ['styles/github.css'],
                ],
            ]
        ],
    ],
    'params' => $params,
    'language' => 'zh-CN',
    'timeZone' => 'Asia/Shanghai',
    'defaultRoute' => '/frontend',
    'modules' => [
        'frontend' => [
            'class' => 'app\modules\frontend\Module',
        ],
        'backend' => [
            'class' => 'app\modules\backend\Module',
        ],
        'user' => [
            'class' => 'app\modules\user\Module',
        ],
        'admin' => [
            'class' => 'mdm\admin\Module',
            'layout' => '@app/views/layouts/backend',
            'controllerMap' => [
                'assignment' => [
                    'class' => 'mdm\admin\controllers\AssignmentController',
                    'searchClass' => 'app\models\search\UserSearch',
                ],
            ],
        ],
        'gridview' => [
            'class' => 'kartik\grid\Module',
        ],
        'redactor' => [
            'class' => 'yii\redactor\RedactorModule',
            'uploadDir' => '@webroot/redactor',
            'uploadUrl' => '@web/redactor',
            'imageAllowExtensions' => ['jpg', 'png', 'gif'],
            'widgetClientOptions' => [
                'minHeight' => 300,
                'maxHeight' => 600,
            ],
        ],
    ],
    'as access' => [
        'class' => 'mdm\admin\components\AccessControl',
        'allowActions' => [
            'debug/*',
            'redactor/*',
            'core/*',
            'frontend/*',
            'user/*',
        ]
    ],
];

/**
 * TODO 在以下添加自己的邮箱配置，才可以使用邮件发送的功能
 */
$config['components']['mailer'] = [
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
        'from' => [
            'hubeiwei1234@163.com' => $config['name'] . ' robot',
        ],
    ],
];

$config['components']['urlManager'] = [
    'enablePrettyUrl' => true,
    'showScriptName' => false,
    'rules' => [
        'login' => '/user/default/login',
        'logout' => '/user/default/logout',
        'register' => '/user/default/register',
    ],
];

$config['components'] = array_merge($config['components'], require(__DIR__ . '/db.php'));

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        'allowedIPs' => [
            '::1',
            '127.0.0.1',
            '192.168.*.*',
        ],
    ];
    if (isset($_SERVER['HTTP_LaoHu'])) {
        $config['modules']['debug']['allowedIPs'] = ['*.*.*.*'];
    };

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
