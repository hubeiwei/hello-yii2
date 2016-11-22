<?php

use app\common\grid\ActionColumn;
use app\common\grid\SerialColumn;
use app\common\helpers\RenderHelper;
use app\common\widgets\DateRangePicker;
use app\models\Setting;
use yii\helpers\Html;

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
        'filter' => RenderHelper::dropDownFilter($searchModel, 'status', Setting::$status_map),
        'headerOptions' => ['width' => 100],
    ],
    'username',
    [
        'attribute' => 'created_at',
        'format' => 'dateTime',
        'filterType' => DateRangePicker::className(),
        'filterWidgetOptions' => ['dateOnly' => false],
        'headerOptions' => ['width' => 160],
    ],
    [
        'attribute' => 'updated_at',
        'format' => 'dateTime',
        'filterType' => DateRangePicker::className(),
        'filterWidgetOptions' => ['dateOnly' => false],
        'headerOptions' => ['width' => 160],
    ],

    ['class' => ActionColumn::className()],
];
?>
<div class="setting-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <hr>

    <p>
        <?= Html::a('添加配置', ['create'], ['class' => 'btn btn-info']) ?>
    </p>

    <?= RenderHelper::gridView($dataProvider, $gridColumns, $searchModel) ?>
    
</div>
