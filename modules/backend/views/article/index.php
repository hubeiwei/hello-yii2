<?php

use app\models\Article;
use hubeiwei\yii2tools\grid\ActionColumn;
use hubeiwei\yii2tools\grid\SerialColumn;
use hubeiwei\yii2tools\helpers\Render;
use hubeiwei\yii2tools\widgets\DateRangePicker;
use hubeiwei\yii2tools\widgets\Select2;
use yii\helpers\Html;

/**
 * @var $this yii\web\View
 * @var $searchModel app\models\search\ArticleSearch
 * @var $dataProvider yii\data\ActiveDataProvider
 */

$this->title = '文章';
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['index']];

$gridColumns = [
    ['class' => SerialColumn::className()],

    'title',
    'username',
    [
        'attribute' => 'published_at',
        'format' => ['dateTime', 'php:Y-m-d H:i'],
        'filterType' => DateRangePicker::className(),
        'filterWidgetOptions' => [
            'pluginOptions' => [
                'locale' => [
                    'format' => 'Y/m/d H:i',
                ],
            ],
        ],
    ],
    [
        'attribute' => 'visible',
        'value' => function ($model) {
            return Article::visibleMap($model->visible);
        },
        'filterType' => Select2::className(),
        'filterWidgetOptions' => [
            'data' => Article::visibleMap(),
        ],
    ],
    [
        'attribute' => 'type',
        'value' => function ($model) {
            return Article::typeMap($model->type);
        },
        'filterType' => Select2::className(),
        'filterWidgetOptions' => [
            'data' => Article::typeMap(),
        ],
        'filterOptions' => [
            'style' => [
                'min-width' => '120px',
            ],
        ],
    ],
    [
        'attribute' => 'status',
        'value' => function ($model) {
            return Article::statusMap($model->status);
        },
        'filterType' => Select2::className(),
        'filterWidgetOptions' => [
            'data' => Article::statusMap(),
        ],
    ],
    [
        'attribute' => 'created_at',
        'format' => 'dateTime',
        'filterType' => DateRangePicker::className(),
    ],
    [
        'attribute' => 'updated_at',
        'format' => 'dateTime',
        'filterType' => DateRangePicker::className(),
    ],

    ['class' => ActionColumn::className()],
];
?>
<div class="article-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <hr>

    <?= Render::dynaGrid([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => $gridColumns,
    ]) ?>

</div>
