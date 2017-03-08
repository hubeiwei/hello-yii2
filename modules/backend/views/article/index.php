<?php

use app\common\grid\ActionColumn;
use app\common\grid\SerialColumn;
use app\common\helpers\RenderHelper;
use app\common\widgets\DateRangePicker;
use app\common\widgets\Select2;
use app\models\Article;
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
    [
        'attribute' => 'username',
        'headerOptions' => ['width' => 160],
    ],
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
        'headerOptions' => ['width' => 160],
    ],
    [
        'attribute' => 'visible',
        'value' => function ($model) {
            return Article::$visible_map[$model->visible];
        },
        'filterType' => Select2::className(),
        'filterWidgetOptions' => [
            'data' => Article::$visible_map,
        ],
        'headerOptions' => ['width' => 100],
    ],
    [
        'attribute' => 'type',
        'value' => function ($model) {
            return Article::$type_map[$model->type];
        },
        'filterType' => Select2::className(),
        'filterWidgetOptions' => [
            'data' => Article::$type_map,
        ],
        'headerOptions' => ['width' => 100],
    ],
    [
        'attribute' => 'status',
        'value' => function ($model) {
            return Article::$status_map[$model->status];
        },
        'filterType' => Select2::className(),
        'filterWidgetOptions' => [
            'data' => Article::$status_map,
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

    ['class' => ActionColumn::className()],
];
?>
<div class="article-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <hr>

    <?= RenderHelper::dynaGrid('backend-article-index', $dataProvider, $gridColumns, $searchModel) ?>

</div>
