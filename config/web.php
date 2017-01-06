<?php

$config = [
    'id' => 'basic',
    'name' => 'Hello yii2',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'language' => 'zh-CN',
    'timeZone' => 'Asia/Shanghai',
    'defaultRoute' => '/frontend',
    'modules' => require(__DIR__ . '/modules.php'),
    'as access' => [
        'class' => 'mdm\admin\components\AccessControl',
        'allowActions' => [
            'site/error',
            'site/captcha',
            'frontend/*',
            'user/*',
            'debug/*',
            'gridview/*',
            'dynagrid/*',
            'redactor/*',
        ],
    ],
];

$config['params'] = array_merge(
    require(__DIR__ . '/params.php')
);

$config['components'] = array_merge(
    require(__DIR__ . '/components.php'),
    require(__DIR__ . '/db.php')// 数据库
);

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
