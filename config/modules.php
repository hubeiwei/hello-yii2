<?php

use kartik\dynagrid\DynaGrid;

return [
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
            /**
             * 虽然在RenderHelper有根据业务来封装，但为了单独使用DynaGrid，在这里进行部分配置
             * @see \app\common\helpers\RenderHelper::dynaGrid()
             *
             * TODO TYPE_DB需要执行以下命令：
             * ```
             * php yii migrate --migrationPath=@kartik/dynagrid/migrations
             * ```
             */
            'storage' => DynaGrid::TYPE_DB,
            'gridOptions' => [
                'dataColumnClass' => 'app\common\grid\DataColumn',
                'resizableColumns' => false,
                'responsiveWrap' => false,
                'hover' => true,
                'export' => false,
                'pager' => [
                    'firstPageLabel' => '首页',
                    'lastPageLabel' => '尾页',
                ],
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
];
