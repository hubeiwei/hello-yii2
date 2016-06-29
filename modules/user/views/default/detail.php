<?php

/**
 * @var $this yii\web\View
 * @var $model app\modules\user\models\UserDetailForm
 */

$this->title = '个人资料';
//$this->params['breadcrumbs'][] = ['label' => $this->title];
?>
<div class="user-detail-update">

    <?= $this->render('_user-detail-form', [
        'model' => $model,
    ]) ?>

</div>
