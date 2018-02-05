<?php

use app\common\helpers\UserHelper;
use app\models\User;
use hubeiwei\yii2tools\grid\ActionColumn;
use hubeiwei\yii2tools\grid\SerialColumn;
use hubeiwei\yii2tools\helpers\RenderHelper;
use hubeiwei\yii2tools\widgets\DateRangePicker;
use hubeiwei\yii2tools\widgets\Select2;
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
            return User::statusMap($model->status);
        },
        'filterType' => Select2::className(),
        'filterWidgetOptions' => [
            'data' => User::statusMap(),
        ],
        'headerOptions' => ['width' => 100],
    ],
    [
        'attribute' => 'created_at',
        'format' => 'dateTime',
        'filterType' => DateRangePicker::className(),
        'headerOptions' => ['width' => 160],
    ],
    [
        'attribute' => 'updated_at',
        'format' => 'dateTime',
        'filterType' => DateRangePicker::className(),
        'headerOptions' => ['width' => 160],
    ],

    [
        'class' => ActionColumn::className(),
        'visibleButtons' => [
            'delete' => function ($model, $key, $index) {
                return UserHelper::getUserId() != $model->id;
            },
        ],
    ],
];
?>
<div class="sys-user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <hr>

    <p>
        <?= Html::a('添加用户', ['create'], ['class' => 'btn btn-info']) ?>
    </p>

    <?= RenderHelper::dynaGrid('backend-user-index', $dataProvider, $gridColumns, $searchModel) ?>

</div>
