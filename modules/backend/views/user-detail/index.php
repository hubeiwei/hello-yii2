<?php

use app\models\UserDetail;
use hubeiwei\yii2tools\grid\ActionColumn;
use hubeiwei\yii2tools\grid\SerialColumn;
use hubeiwei\yii2tools\helpers\RenderHelper;
use hubeiwei\yii2tools\widgets\DateRangePicker;
use hubeiwei\yii2tools\widgets\Select2;
use yii\helpers\Html;

/**
 * @var $this yii\web\View
 * @var $searchModel app\models\search\UserDetailSearch
 * @var $dataProvider yii\data\ActiveDataProvider
 */

$this->title = '用户资料';
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['index']];

$gridColumns = [
    ['class' => SerialColumn::className()],

    'user_id',
    [
        'attribute' => 'username',
        'value' => function ($model) {
            return Html::a($model->user['username'], ['user/index', 'UserSearch[id]' => $model->user_id]);
        },
        'format' => 'html',
    ],
//    [
//        'attribute' => 'avatar_file',
//        'headerOptions' => ['width' => 160],
//    ],
    [
        'attribute' => 'gender',
        'value' => function ($model) {
            return UserDetail::$gender_map[$model->gender];
        },
        'filterType' => Select2::className(),
        'filterWidgetOptions' => [
            'data' => UserDetail::$gender_map,
        ],
        'headerOptions' => ['width' => 100],
    ],
    [
        'attribute' => 'birthday',
        'format' => 'date',
        'filterType' => DateRangePicker::className(),
        'filterWidgetOptions' => ['dateOnly' => true],
    ],
    'phone',
    [
        'attribute' => 'updated_at',
        'format' => 'dateTime',
        'filterType' => DateRangePicker::className(),
    ],

    [
        'class' => ActionColumn::className(),
        'template' => '{view} {update}',
        'headerOptions' => ['width' => 60],
        'width' => false,
    ],
];
?>
<div class="user-detail-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <hr>

    <?= RenderHelper::dynaGrid('backend-user-detail-index', $dataProvider, $gridColumns, $searchModel) ?>

</div>
