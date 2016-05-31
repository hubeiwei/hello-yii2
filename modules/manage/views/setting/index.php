<?php

use app\models\Setting;
use app\modules\core\helpers\EasyHelper;
use app\modules\core\helpers\RenderHelper;
use yii\helpers\Html;
use kartik\grid\SerialColumn;
use kartik\grid\ActionColumn;

/**
 * @var $this yii\web\View
 * @var $searchModel app\models\search\SettingSearch
 * @var $dataProvider yii\data\ActiveDataProvider
 */

$this->title = '网站配置';
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['index']];

$gridColumns = [
    ['class' => SerialColumn::className()],

    [
        'attribute' => 'id',
        'headerOptions' => ['width' => 80],
    ],
    'key',
    'value',
    'description',
    'tag',
    [
        'attribute' => 'status',
        'value' => function ($model) {
            return Setting::$status_map[$model->status];
        },
        'filter' => RenderHelper::dropDownFilter('SettingSearch[status]', $searchModel->status, Setting::$status_map),
        'headerOptions' => ['width' => 100],
    ],
    [
        'attribute' => 'created_by',
        'value' => 'creater.username',
    ],
    [
        'attribute' => 'updated_by',
        'value' => 'updater.username',
    ],
    [
        'attribute' => 'created_at',
        'value' => function ($model) {
            return EasyHelper::timestampToDate($model->created_at);
        },
        'filter' => RenderHelper::dateRangePicker('SettingSearch[created_at]'),
        'headerOptions' => ['width' => 160],
    ],
    [
        'attribute' => 'updated_at',
        'value' => function ($model) {
            return EasyHelper::timestampToDate($model->updated_at);
        },
        'filter' => RenderHelper::dateRangePicker('SettingSearch[updated_at]'),
        'headerOptions' => ['width' => 160],
    ],

    ['class' => ActionColumn::className()],
];
?>
<div class="setting-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <hr>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('添加配置', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= RenderHelper::gridView($dataProvider, $searchModel, $gridColumns) ?>
    
</div>
