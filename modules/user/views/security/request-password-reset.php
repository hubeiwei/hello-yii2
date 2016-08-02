<?php

use app\modules\core\extensions\HuCaptcha;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/**
 * @var $this yii\web\View
 * @var $model \app\modules\user\models\PasswordResetRequest
 */

$this->title = '找回密码';
?>
<div class="site-request-password-reset">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'email')->textInput(['placeholder' => '请输入您注册时的邮箱']) ?>

    <?= $form->field($model, 'verifyCode')->widget(HuCaptcha::className()) ?>

    <?= Html::submitButton('发送', ['class' => 'btn btn-primary']) ?>

    <?php ActiveForm::end(); ?>

</div>
