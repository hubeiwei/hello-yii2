<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'basic',
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
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
            'loginUrl' => ['/user/default/login'],//登录的url，权限管理需要，游客访问一些需要权限的url时会往该链接跳转
        ],
        'errorHandler' => [
            'errorAction' => '/core/default/error',//挪地方了
        ],
        //邮箱
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
        'db' => require(__DIR__ . '/db.php'),
        //权限管理
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
            'defaultRoles' => ['Guest'],//默认角色
        ],
        'formatter' => [
            'dateFormat' => 'php:Y-m-d',
            'datetimeFormat' => 'php:Y-m-d H:i:s',
        ],
    ],
    'params' => $params,
    'language' => 'zh-CN',
    'timeZone' => 'Asia/Shanghai',
    'defaultRoute' => '/portal/article',//访问入口文件后默认转到的url
    'modules' => [
        'gridview' => [
            'class' => 'kartik\grid\Module',
        ],
        'admin' => [
            'class' => 'mdm\admin\Module',
            'layout' => 'left-menu',
            'controllerMap' => [
                'assignment' => [
                    'class' => 'mdm\admin\controllers\AssignmentController',
                    'idField' => 'user_id',
                    'searchClass' => 'app\models\search\UserSearch',
                ]
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
        //前台用户用到的，比如登录、登出、注册、找回密码、修改密码什么的
        'user' => [
            'class' => 'app\modules\user\Module',
        ],
        //前台
        'portal' => [
            'class' => 'app\modules\portal\Module',
        ],
    ],
    //访问控制
    'as access' => [
        'class' => 'mdm\admin\components\AccessControl',
        //允许所有身份访问的路由，开头不要像写url那样加/，亲测无效，无限跳转到登录
        'allowActions' => [
            'debug/*',
//            'gii/*',
//            'admin/*',
            'redactor/*',
            'core/*',
            'portal/*',
            'user/*',
        ]
    ],
];

/**
 * TODO 因为后台菜单需要，所以需要把站点根目录设置为/web，apache需要开启rewrite，nginx还没用过，自行解决吧，以后再考虑如何处理这个问题。
 */
$config['components']['urlManager'] = [
    'enablePrettyUrl' => true,
    'showScriptName' => false,

    /**
     * 之前因为照顾到没有配apache的rewrite的同学，
     * 用到这些别名的地方都改回去了，
     * 现在这些别名也只是方便手敲而已
     */
    'rules' => [
        'login' => '/user/default/login',
        'logout' => '/user/default/logout',
        'register' => '/user/default/register',
    ],
];

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
    //外网专用，有兴趣的去研究一下$_SERVER与header的关系
    if (isset($_SERVER['HTTP_LaoHu'])) {
        $config['modules']['debug']['allowedIPs'] = ['*.*.*.*'];
    };

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
