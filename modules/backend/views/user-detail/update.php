<?php

use yii\helpers\Html;

/**
 * @var $this yii\web\View
 * @var $model app\models\UserDetail
 * @var $validator app\modules\user\models\UserDetailValidator
 */

$this->title = '修改用户资料: ' . $model->user->username;
$this->params['breadcrumbs'][] = ['label' => '用户资料', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->user->username, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = '修改';
?>
<div class="user-detail-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <hr>

    <?= $this->render('@app/modules/user/views/setting/_user-detail-form', [
        'model' => $model,
        'validator' => $validator,
    ]) ?>
    
</div>
