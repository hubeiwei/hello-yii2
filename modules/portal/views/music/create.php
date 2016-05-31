<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var app\modules\portal\models\MusicUploadForm $model
 */

$this->title = '添加音乐';
$this->params['breadcrumbs'][] = ['label' => '音乐', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="music-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <hr>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
