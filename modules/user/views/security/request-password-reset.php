<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/**
 * @var $this yii\web\View
 * @var $model \app\modules\user\models\PasswordResetRequest
 */

$this->title = '找回密码';
?>
<div class="site-request-password-reset">
    <div class="row">
        <div class="col-md-5">

            <?php $form = ActiveForm::begin(); ?>

            <?= $form->field($model, 'email')->textInput(['placeholder' => '请输入您注册时的邮箱']) ?>

            <div class="form-group">
                <?= Html::submitButton('发送', ['class' => 'btn btn-primary']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
