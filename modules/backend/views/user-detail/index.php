<?php

use app\models\UserDetail;
use app\modules\core\grid\ActionColumn;
use app\modules\core\grid\SerialColumn;
use app\modules\core\helpers\RenderHelper;
use app\modules\core\widgets\DateRangePicker;
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
    [
        'attribute' => 'avatar_file',
//        'headerOptions' => ['width' => 160],
    ],
    [
        'attribute' => 'gender',
        'value' => function ($model) {
            return UserDetail::$gender_map[$model->gender];
        },
        'filter' => RenderHelper::dropDownFilter($searchModel, 'gender', UserDetail::$gender_map),
    ],
    [
        'attribute' => 'birthday',
        'format' => 'date',
        'filterType' => DateRangePicker::className(),
    ],
    'phone',
    [
        'attribute' => 'updated_at',
        'format' => 'dateTime',
        'filterType' => DateRangePicker::className(),
        'filterWidgetOptions' => [
            'dateOnly' => false,
        ],
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

    <?= RenderHelper::gridView($dataProvider, $gridColumns, $searchModel, true) ?>
    
</div>
