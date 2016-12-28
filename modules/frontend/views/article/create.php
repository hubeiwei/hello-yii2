<?php

use yii\helpers\Html;

/**
 * @var $this yii\web\View
 * @var $model app\models\Article
 * @var $validator app\modules\frontend\models\ArticleValidator
 */

$this->title = '发布文章';
$this->params['breadcrumbs'][] = ['label' => '文章', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <hr>

    <?= $this->render('_form', [
        'model' => $model,
        'validator' => $validator,
    ]) ?>

</div>
