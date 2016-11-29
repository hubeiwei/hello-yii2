<?php

use yii\helpers\Html;

/**
 * @var $this yii\web\View
 * @var $model app\modules\user\models\UserDetailForm
 */

$this->title = '个人资料';
?>
<div class="user-detail-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <hr>

    <?= $this->render('_user-detail-form', [
        'model' => $model,
    ]) ?>

</div>
