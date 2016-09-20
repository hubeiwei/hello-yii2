<?php

use app\modules\core\widget\HuCaptcha;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/**
 * @var $this yii\web\View
 * @var $model \app\modules\user\models\PasswordResetRequest
 */

$this->title = '找回密码';
?>
<div class="site-request-password-reset">

    <h1><?= Html::encode($this->title) ?></h1>

    <hr>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'email')->textInput([
        'autofocus' => true,
        'placeholder' => '请输入您注册时的邮箱',
    ]) ?>

    <?= $form->field($model, 'verifyCode')->widget(HuCaptcha::className()) ?>

    <div class="form-group">
        <?= Html::submitButton('发送邮件', ['class' => 'btn btn-primary btn-block']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
