<?php

use kartik\dynagrid\DynaGrid;

$config = [
    'frontend' => [
        'class' => 'app\modules\frontend\Module',
    ],
    'backend' => [
        'class' => 'app\modules\backend\Module',
        'layout' => '@app/views/layouts/backend',
    ],
    'user' => [
        'class' => 'app\modules\user\Module',
        'layout' => '@app/views/layouts/user',
        'controllerMap' => [
            'default' => [
                'class' => 'app\modules\user\controllers\DefaultController',
                'layout' => '@app/views/layouts/user_form',
            ],
            'security' => [
                'class' => 'app\modules\user\controllers\SecurityController',
                'layout' => '@app/views/layouts/user_form',
            ],
        ],
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
    'dynagrid' => [
        'class' => 'kartik\dynagrid\Module',
        'dbSettings' => [
            'tableName' => 'dynagrid',
        ],
        'dbSettingsDtl' => [
            'tableName' => 'dynagrid_dtl',
        ],
        'dynaGridOptions' => [
            'storage' => DynaGrid::TYPE_DB,
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
];

return $config;
