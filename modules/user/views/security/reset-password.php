<?php

use app\modules\core\extensions\HuCaptcha;
use kartik\password\PasswordInput;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/**
 * @var $this yii\web\View
 * @var $model \app\modules\user\models\ResetPassword
 */

$this->title = '重置密码';
?>
<div class="site-reset-password">
    <div class="row">
        <div class="col-md-5">

            <?php $form = ActiveForm::begin(); ?>

            <?= $form->field($model, 'password')->widget(PasswordInput::className(), ['options' => ['maxlength' => 20]]) ?>

            <?= $form->field($model, 'password_repeat')->passwordInput(['maxlength' => 20]) ?>

            <?= $form->field($model, 'verifyCode')->widget(HuCaptcha::className()) ?>

            <div class="form-group">
                <?= Html::submitButton('重置密码', ['class' => 'btn btn-primary']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
