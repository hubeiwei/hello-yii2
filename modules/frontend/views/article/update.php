<?php

use yii\helpers\Html;

/**
 * @var $this yii\web\View
 * @var $model app\models\Article
 * @var $validator app\modules\frontend\models\ArticleValidator
 */

$this->title = '修改文章：' . $model->title;
$this->params['breadcrumbs'][] = ['label' => '文章', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = '修改';
?>
<div class="article-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <hr>

    <?= $this->render('_form', [
        'model' => $model,
        'validator' => $validator,
    ]) ?>

</div>
