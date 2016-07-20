<?php

use app\models\Article;
use app\modules\core\helpers\RenderHelper;
use kartik\grid\ActionColumn;
use kartik\grid\SerialColumn;
use yii\bootstrap\ButtonDropdown;
use yii\helpers\Html;

/**
 * @var $this yii\web\View
 * @var $searchModel app\models\search\ArticleSearch
 * @var $dataProvider yii\data\ActiveDataProvider
 */

$this->title = '我的文章';
$this->params['breadcrumbs'][] = ['label' => '文章', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['my-article']];

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
        'filter' => RenderHelper::dateRangePicker($searchModel, 'published_at', false),
        'headerOptions' => ['width' => 160],
    ],
    [
        'attribute' => 'visible',
        'value' => function ($model) {
            return Article::$visible_map[$model->visible];
        },
        'filter' => RenderHelper::dropDownFilter('ArticleSearch[visible]', $searchModel->visible, Article::$visible_map),
        'headerOptions' => ['width' => 100],
    ],
    [
        'attribute' => 'type',
        'value' => function ($model) {
            return Article::$type_map[$model->type];
        },
        'filter' => RenderHelper::dropDownFilter('ArticleSearch[type]', $searchModel->type, Article::$type_map),
        'headerOptions' => ['width' => 100],
    ],
    [
        'attribute' => 'status',
        'value' => function ($model) {
            return Article::$status_map[$model->status];
        },
        'filter' => RenderHelper::dropDownFilter('ArticleSearch[status]', $searchModel->status, Article::$status_map),
        'headerOptions' => ['width' => 100],
    ],
    [
        'attribute' => 'created_at',
        'format' => 'dateTime',
        'filter' => RenderHelper::dateRangePicker($searchModel, 'created_at', false),
        'headerOptions' => ['width' => 160],
    ],
    [
        'attribute' => 'updated_at',
        'format' => 'dateTime',
        'filter' => RenderHelper::dateRangePicker($searchModel, 'updated_at', false),
        'headerOptions' => ['width' => 160],
    ],

    ['class' => ActionColumn::className()],
];
?>
<div class="article-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

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

    <?= RenderHelper::gridView($dataProvider, $searchModel, $gridColumns) ?>

</div>
