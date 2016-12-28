<?php

use yii\helpers\Html;

/**
 * @var $this yii\web\View
 * @var $model app\models\UserDetail
 * @var $validator app\modules\user\models\UserDetailValidator
 */

$this->title = '个人资料';
?>
<div class="user-detail-update">

    <?= $this->render('_user-detail-form', [
        'model' => $model,
        'validator' => $validator,
    ]) ?>

</div>
