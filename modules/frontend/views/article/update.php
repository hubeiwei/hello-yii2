<?php

/**
 * @var $this yii\web\View
 * @var $model app\models\Article
 * @var $validator app\modules\frontend\models\ArticleValidator
 */

$this->title = '修改文章：' . $model->title;
$this->params['breadcrumbs'][] = ['label' => '我的文章', 'url' => ['my-article']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = '修改';
?>
<div class="article-update">

    <?= $this->render('_form', [
        'model' => $model,
        'validator' => $validator,
    ]) ?>

</div>
