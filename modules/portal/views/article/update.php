<?php

use app\models\Article;
use yii\helpers\Html;

/**
 * @var $this yii\web\View
 * @var $model app\modules\portal\models\ArticleForm
 * @var $id int
 */

$this->title = '修改文章：' . $model->title;
$this->params['breadcrumbs'][] = ['label' => '文章', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $id]];
$this->params['breadcrumbs'][] = '修改';
?>
<div class="article-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
