<?php

use app\models\User;
use app\modules\core\helpers\RenderHelper;
use kartik\grid\ActionColumn;
use kartik\grid\SerialColumn;
use yii\helpers\Html;

/**
 * @var $this yii\web\View
 * @var $searchModel app\models\search\UserSearch
 * @var $dataProvider yii\data\ActiveDataProvider
 */

$this->title = '用户管理';
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['index']];

$gridColumns = [
    ['class' => SerialColumn::className()],

    [
        'attribute' => 'id',
        'headerOptions' => ['width' => 80],
    ],
    'username',
    'email:email',
    [
        'attribute' => 'status',
        'value' => function ($model) {
            return User::$status_map[$model->status];
        },
        'filter' => RenderHelper::dropDownFilter('UserSearch[status]', $searchModel->status, User::$status_map),
        'headerOptions' => ['width' => 100],
    ],
    [
        'attribute' => 'created_at',
        'format' => 'dateTime',
        'filter' => RenderHelper::dateRangePicker($searchModel, 'created_at'),
        'headerOptions' => ['width' => 160],
    ],
    [
        'attribute' => 'updated_at',
        'format' => 'dateTime',
        'filter' => RenderHelper::dateRangePicker($searchModel, 'updated_at'),
        'headerOptions' => ['width' => 160],
    ],

    ['class' => ActionColumn::className()],
];
?>
<div class="sys-user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <hr>

    <p>
        <?= Html::a('添加用户', ['create'], ['class' => 'btn btn-info']) ?>
    </p>

    <?= RenderHelper::gridView($dataProvider, $searchModel, $gridColumns) ?>
    
</div>
