<?php

/**
 * @var yii\web\View $this
 * @var app\modules\portal\models\MusicForm $model
 */

$this->title = '添加音乐';
$this->params['breadcrumbs'][] = ['label' => '音乐', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="music-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
