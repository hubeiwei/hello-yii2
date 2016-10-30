<?php

use app\modules\core\widgets\Captcha;
use kartik\password\PasswordInput;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var $this yii\web\View
 * @var $model app\modules\user\models\LoginForm
 */

$this->title = '登录';
?>
<div class="site-login">

    <h1><?= Html::encode($this->title) ?></h1>

    <hr>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'username')->textInput([
        'autofocus' => true,
        'maxlength' => true,
    ]) ?>

    <?= $form->field($model, 'password')->widget(PasswordInput::className(), [
        'options' => ['maxlength' => 20],
        'pluginOptions' => [
            'showMeter' => false,
            'mainTemplate' => '{input}',
        ],
    ]) ?>

    <?= $form->field($model, 'verifyCode')->widget(Captcha::className()) ?>

    <?= $form->field($model, 'rememberMe')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton('登录', ['class' => 'btn btn-primary btn-block']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    <div class="form-group">
        忘记密码？<?= Html::a('找回密码', ['/user/security/request-password-reset']) ?>
    </div>

    <div class="form-group">
        还没有帐号？<?= Html::a('注册', ['/register']) ?>
    </div>

</div>
