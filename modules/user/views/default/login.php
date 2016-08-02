<?php

use app\modules\core\extensions\HuCaptcha;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var $this yii\web\View
 * @var $model app\modules\user\models\LoginForm
 */

$this->title = '登录';
?>
<div class="site-login">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'username')->textInput([
        'autofocus' => true,
        'maxlength' => true,
    ]) ?>

    <?= $form->field($model, 'password')->passwordInput([
        'maxlength' => true,
    ]) ?>

    <?= $form->field($model, 'verifyCode')->widget(HuCaptcha::className()) ?>

    <?= $form->field($model, 'rememberMe')->checkbox() ?>

    <?= Html::submitButton('登录', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>

    <?= Html::a('找回密码', ['/user/security/request-password-reset'], ['class' => 'btn btn-danger']) ?>

    <?php ActiveForm::end(); ?>

</div>
