<?php

use app\models\Article;
use app\modules\core\helpers\EasyHelper;
use app\modules\core\helpers\RenderHelper;
use kartik\grid\ActionColumn;
use kartik\grid\SerialColumn;
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
        'attribute' => 'user.username',
        'headerOptions' => ['width' => 160],
    ],
    [
        'attribute' => 'published_at',
        'value' => function ($model) {
            return EasyHelper::timestampToDate($model->published_at, 'Y-m-d H:i');
        },
        'filter' => RenderHelper::dateRangePicker('ArticleSearch[published_at]', false),
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
        'value' => function ($model) {
            return EasyHelper::timestampToDate($model->created_at);
        },
        'filter' => RenderHelper::dateRangePicker('ArticleSearch[created_at]', false),
        'headerOptions' => ['width' => 160],
    ],
    [
        'attribute' => 'updated_at',
        'value' => function ($model) {
            return EasyHelper::timestampToDate($model->updated_at);
        },
        'filter' => RenderHelper::dateRangePicker('ArticleSearch[updated_at]', false),
        'headerOptions' => ['width' => 160],
    ],

    ['class' => ActionColumn::className()],
];
?>
<div class="article-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <hr>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= RenderHelper::gridView($dataProvider, $searchModel, $gridColumns) ?>

</div>
