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
        'attribute' => 'user_id',
        'headerOptions' => ['width' => 80],
    ],
    'username',
    [
        'attribute' => 'type',
        'value' => function ($model) {
            return User::$type_map[$model->type];
        },
        'filter' => RenderHelper::dropDownFilter('UserSearch[type]', $searchModel->type, User::$type_map),
        'headerOptions' => ['width' => 120],
    ],
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
        'filter' => RenderHelper::dateRangePicker('UserSearch[created_at]'),
        'headerOptions' => ['width' => 160],
    ],
    [
        'attribute' => 'updated_at',
        'format' => 'dateTime',
        'filter' => RenderHelper::dateRangePicker('UserSearch[updated_at]'),
        'headerOptions' => ['width' => 160],
    ],
    [
        'attribute' => 'last_login',
        'format' => 'dateTime',
        'filter' => RenderHelper::dateRangePicker('UserSearch[last_login]'),
        'headerOptions' => ['width' => 160],
    ],
    'last_ip',

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
