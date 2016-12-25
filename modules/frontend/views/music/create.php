<?php

use yii\helpers\Html;

/**
 * @var $this yii\web\View
 * @var $model app\models\Music
 * @var $validator app\modules\frontend\models\MusicValidator
 */

$this->title = '上传音乐';
$this->params['breadcrumbs'][] = ['label' => '音乐', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="music-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <hr>

    <?= $this->render('_form', [
        'model' => $model,
        'validator' => $validator,
    ]) ?>

</div>
