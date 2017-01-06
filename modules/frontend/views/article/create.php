<?php

/**
 * @var $this yii\web\View
 * @var $model app\models\Article
 * @var $validator app\modules\frontend\models\ArticleValidator
 */

$this->title = '发布文章';
$this->params['breadcrumbs'][] = ['label' => '我的文章', 'url' => ['my-article']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-create">

    <?= $this->render('_form', [
        'model' => $model,
        'validator' => $validator,
    ]) ?>

</div>
