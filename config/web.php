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
            'errorAction' => '/core/default/error',
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
                'nezhelskoy\highlight\HighlightAsset' => [
                    'css' => ['dist/styles/github.css'],
                ],
            ]
        ],
    ],
    'params' => $params,
    'language' => 'zh-CN',
    'timeZone' => 'Asia/Shanghai',
    'defaultRoute' => '/portal/article',
    'modules' => [
        'gridview' => [
            'class' => 'kartik\grid\Module',
        ],
        'admin' => [
            'class' => 'mdm\admin\Module',
            'layout' => '@app/modules/manage/views/layouts/main',
            'controllerMap' => [
                'assignment' => [
                    'class' => 'mdm\admin\controllers\AssignmentController',
                    'searchClass' => 'app\models\search\UserSearch',
                ],
            ],
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
        //封装和继承一些代码的地方
        'core' => [
            'class' => 'app\modules\core\Module',
        ],
        //后台
        'manage' => [
            'class' => 'app\modules\manage\Module',
        ],
        //用户
        'user' => [
            'class' => 'app\modules\user\Module',
        ],
        //前台
        'portal' => [
            'class' => 'app\modules\portal\Module',
        ],
    ],
    'as access' => [
        'class' => 'mdm\admin\components\AccessControl',
        'allowActions' => [
            'debug/*',
            'redactor/*',
            'core/*',
            'portal/*',
            'user/*',
        ]
    ],
];

/**
 * TODO 如果你要运行我的项目，请把以下邮箱配置改成自己的，谢谢合作
 */
$config['components']['mailer'] = [
    'class' => 'yii\swiftmailer\Mailer',
    'useFileTransport' => false,
    'transport' => [
        'class' => 'Swift_SmtpTransport',
        'host' => 'smtp.163.com',
        'port' => '25',
        'username' => 'hubeiwei1234@163.com',
        'password' => 'Hu407519063',
        'encryption' => 'tls',
    ],
    'messageConfig' => [
        'charset' => 'UTF-8',
        'from' => [
            'hubeiwei1234@163.com' => $config['name'] . ' robot',
        ],
    ],
];

/**
 * TODO 因为后台菜单需要，所以需要把站点根目录设置为/web，apache需要开启rewrite，nginx还没用过，自行解决吧，以后再考虑如何处理这个问题。
 */
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
