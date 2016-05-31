<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var app\modules\portal\models\MusicUpdateForm $model
 */

$this->title = '修改音乐: ' . $model->track_title;
$this->params['breadcrumbs'][] = ['label' => '音乐', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->track_title];
$this->params['breadcrumbs'][] = '修改';
?>
<div class="music-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <hr>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
