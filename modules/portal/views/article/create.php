<?php

use app\models\Article;
use yii\helpers\Html;

/**
 * @var $this yii\web\View
 * @var $model app\modules\portal\models\ArticleForm
 */

$this->title = '发布文章';
$this->params['breadcrumbs'][] = ['label' => '文章', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
