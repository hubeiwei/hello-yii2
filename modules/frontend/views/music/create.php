<?php

/**
 * @var $this yii\web\View
 * @var $model app\models\Music
 * @var $validator app\modules\frontend\models\MusicValidator
 */

$this->title = '上传音乐';
$this->params['breadcrumbs'][] = ['label' => '我的音乐', 'url' => ['my-music']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="music-create">

    <?= $this->render('_form', [
        'model' => $model,
        'validator' => $validator,
    ]) ?>

</div>
