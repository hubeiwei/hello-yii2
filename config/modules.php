<?php

return [
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
];
