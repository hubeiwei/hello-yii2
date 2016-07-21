<?php

use nezhelskoy\highlight\HighlightAsset;

/**
 * @var $this yii\web\View
 * @var $model app\models\Article
 */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => '文章', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

HighlightAsset::register($this);
?>
<div class="article-view">

    <p>作者：<?= $model->user->username ?></p>

    <p>发布时间：<?= date('Y-m-d H:i', $model->published_at) ?></p>

    <hr>

    <?= $model->processArticle() ?>

</div>
