<?php

use app\assets\HighlightAsset;
use app\models\Article;
use yii\helpers\Html;
use yii\widgets\DetailView;

/**
 * @var $this yii\web\View
 * @var $model app\models\Article
 */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => '我的文章', 'url' => ['my-article']];
$this->params['breadcrumbs'][] = $this->title;

HighlightAsset::register($this);
?>
<div class="article-view">

    <p>
        <?= Html::a('修改', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('删除', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '确定要删除这篇文章吗？',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            'user.username',
            [
                'attribute' => 'published_at',
                'format' => ['dateTime', 'php:Y-m-d H:i'],
            ],
            [
                'attribute' => 'visible',
                'value' => Article::visibleMap($model->visible),
            ],
            [
                'attribute' => 'type',
                'value' => Article::typeMap($model->type),
            ],
            [
                'attribute' => 'status',
                'value' => Article::statusMap($model->status),
            ],
            'created_at:dateTime',
            'updated_at:dateTime',
        ],
    ]) ?>

    <hr>

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $model->processArticle() ?>

</div>
