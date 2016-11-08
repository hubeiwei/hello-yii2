<?php

use app\models\Article;
use app\modules\core\grid\ActionColumn;
use app\modules\core\grid\SerialColumn;
use app\modules\core\helpers\RenderHelper;
use app\modules\core\widgets\DateRangePicker;
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
                'timePicker' => true,
                'timePicker24Hour' => true,
                'timePickerIncrement' => 1,
            ],
        ],
        'headerOptions' => ['width' => 160],
    ],
    [
        'attribute' => 'visible',
        'value' => function ($model) {
            return Article::$visible_map[$model->visible];
        },
        'filter' => RenderHelper::dropDownFilter($searchModel, 'visible', Article::$visible_map),
        'headerOptions' => ['width' => 100],
    ],
    [
        'attribute' => 'type',
        'value' => function ($model) {
            return Article::$type_map[$model->type];
        },
        'filter' => RenderHelper::dropDownFilter($searchModel, 'type', Article::$type_map),
        'headerOptions' => ['width' => 100],
    ],
    [
        'attribute' => 'status',
        'value' => function ($model) {
            return Article::$status_map[$model->status];
        },
        'filter' => RenderHelper::dropDownFilter($searchModel, 'status', Article::$status_map),
        'headerOptions' => ['width' => 100],
    ],
    [
        'attribute' => 'created_at',
        'format' => 'dateTime',
        'filterType' => DateRangePicker::className(),
        'filterWidgetOptions' => [
            'dateOnly' => false,
        ],
        'headerOptions' => ['width' => 160],
    ],
    [
        'attribute' => 'updated_at',
        'format' => 'dateTime',
        'filterType' => DateRangePicker::className(),
        'filterWidgetOptions' => [
            'dateOnly' => false,
        ],
        'headerOptions' => ['width' => 160],
    ],

    ['class' => ActionColumn::className()],
];
?>
<div class="article-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <hr>

    <?= RenderHelper::gridView($dataProvider, $gridColumns, $searchModel) ?>

</div>
