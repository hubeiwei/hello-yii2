<?php

use app\models\Article;
use hubeiwei\yii2tools\grid\ActionColumn;
use hubeiwei\yii2tools\grid\SerialColumn;
use hubeiwei\yii2tools\helpers\Render;
use hubeiwei\yii2tools\widgets\DateRangePicker;
use yii\bootstrap\ButtonDropdown;
use yii\helpers\Html;

/**
 * @var $this yii\web\View
 * @var $searchModel app\models\search\ArticleSearch
 * @var $dataProvider yii\data\ActiveDataProvider
 */

$this->title = '我的文章';

$gridColumns = [
    ['class' => SerialColumn::className()],

    [
        'attribute' => 'title',
        'value' => function ($model) {
            return Html::a($model->title, ['view-article', 'id' => $model->id]);
        },
        'format' => 'html',
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
    ],
    [
        'attribute' => 'visible',
        'value' => function ($model) {
            return Article::visibleMap($model->visible);
        },
        'filter' => Article::visibleMap(),
    ],
    [
        'attribute' => 'type',
        'value' => function ($model) {
            return Article::typeMap($model->type);
        },
        'filter' => Article::typeMap(),
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
        'filter' =>  Article::statusMap(),
    ],
    [
        'attribute' => 'created_at',
        'format' => 'dateTime',
        'filterType' => DateRangePicker::className(),
    ],

    ['class' => ActionColumn::className()],
];
?>
<div class="article-index">

    <?= ButtonDropdown::widget([
        'label' => '发布文章',
        'containerOptions' => [
            'style' => [
                'margin-bottom' => '15px',
            ],
        ],
        'options' => ['class' => 'btn-info'],
        'dropdown' => [
            'items' => [
                ['label' => 'Markdown', 'url' => ['create']],
                ['label' => 'Html', 'url' => ['create', 'type' => Article::TYPE_HTML]],
            ],
        ],
    ]) ?>

    <?= Render::gridView([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => $gridColumns,
    ]) ?>

</div>
