<?php

use app\common\helpers\UserHelper;
use app\models\User;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var $this yii\web\View
 * @var $model User
 */
?>

<div class="sys-user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'username')->textInput([
        'autofocus' => true,
        'maxlength' => true,
        'disabled' => !$model->isNewRecord,// 用户名不可修改
    ]) ?>

    <?php
    if ($model->isNewRecord) {
        echo $form->field($model, 'password_hash')->passwordInput(['maxlength' => true])->label('密码');
    };
    ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?php
    // 不能修改自己的状态，防止无法登录
    if (UserHelper::getUserId() != $model->id) {
        echo $form->field($model, 'status')->dropDownList(User::statusMap());
    }
    ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '添加' : '修改', ['class' => 'btn btn-block ' . ($model->isNewRecord ? 'btn-success' : 'btn-primary')]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
