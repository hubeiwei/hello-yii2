<?php
return [
    'request' => [
        'cookieValidationKey' => '',
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
            'from' => [
                'hubeiwei1234@163.com' => 'Hello yii2 robot',
            ],
        ],
    ],
];
