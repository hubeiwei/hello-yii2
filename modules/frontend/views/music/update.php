<?php

/**
 * @var $this yii\web\View
 * @var $model app\models\Music
 * @var $validator app\modules\frontend\models\MusicValidator
 */

$this->title = '修改音乐: ' . $model->track_title;
$this->params['breadcrumbs'][] = ['label' => '我的音乐', 'url' => ['my-music']];
$this->params['breadcrumbs'][] = ['label' => $model->track_title];
$this->params['breadcrumbs'][] = '修改';
?>
<div class="music-update">

    <?= $this->render('_form', [
        'model' => $model,
        'validator' => $validator,
    ]) ?>

</div>
