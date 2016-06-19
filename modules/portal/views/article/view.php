<?php

use app\models\Article;
use app\modules\core\helpers\EasyHelper;
use yii\helpers\Html;
use yii\widgets\DetailView;

/**
 * @var $this yii\web\View
 * @var $model app\models\Article
 */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => '文章', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-view">

    <p>
        <?= Html::a('修改', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('删除', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
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
                'value' => EasyHelper::timestampToDate($model->published_at, 'Y-m-d H:i'),
            ],
            [
                'attribute' => 'visible',
                'value' => Article::$visible_map[$model->visible],
            ],
            [
                'attribute' => 'type',
                'value' => Article::$type_map[$model->type],
            ],
            [
                'attribute' => 'status',
                'value' => Article::$status_map[$model->status],
            ],
            [
                'attribute' => 'created_at',
                'value' => EasyHelper::timestampToDate($model->created_at),
            ],
            [
                'attribute' => 'updated_at',
                'value' => EasyHelper::timestampToDate($model->updated_at),
            ],
        ],
    ]) ?>

    <hr>

    <?= $model->processArticle() ?>

</div>
