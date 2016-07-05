<?php

use app\models\UserDetail;
use app\modules\core\helpers\RenderHelper;
use kartik\grid\ActionColumn;
use kartik\grid\SerialColumn;
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

    [
        'attribute' => 'user_id',
        'headerOptions' => ['width' => 100],
    ],
    [
        'attribute' => 'user.username',
        'value' => function ($model) {
            return Html::a($model->user['username'], ['user/index', 'UserSearch[user_id]' => $model->user_id]);
        },
        'format' => 'html',
        'headerOptions' => ['width' => 160],
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
        'filter' => RenderHelper::dropDownFilter('UserDetailSearch[gender]', $searchModel->gender, UserDetail::$gender_map),
        'headerOptions' => ['width' => 100],
    ],
    [
        'attribute' => 'birthday',
        'format' => 'date',
        'filter' => RenderHelper::dateRangePicker('UserDetailSearch[birthday]'),
        'headerOptions' => ['width' => 100],
    ],
    'email:email',
    [
        'attribute' => 'phone',
        'headerOptions' => ['width' => 120],
    ],
    [
        'attribute' => 'updated_at',
        'format' => 'dateTime',
        'filter' => RenderHelper::dateRangePicker('UserDetailSearch[updated_at]'),
        'headerOptions' => ['width' => 160],
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

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= RenderHelper::gridView($dataProvider, $searchModel, $gridColumns, true) ?>
    
</div>
