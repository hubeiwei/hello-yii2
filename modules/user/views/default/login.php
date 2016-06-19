<?php

use app\modules\core\extensions\HuActiveForm;
use app\modules\core\extensions\HuCaptcha;
use yii\helpers\Html;

/**
 * @var $this yii\web\View
 * @var $model app\modules\user\models\LoginForm
 */

$this->title = '登录';
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">

    <?php $form = HuActiveForm::begin(); ?>

    <?= $form->field($model, 'username')->textInput([
        'maxlength' => true,
        'autofocus' => true,
    ]) ?>

    <?= $form->field($model, 'password')->passwordInput([
        'maxlength' => true,
    ]) ?>

    <?= $form->field($model, 'verifyCode')->widget(HuCaptcha::className()) ?>

    <?= $form->field($model, 'rememberMe', [
        'template' => '<div class="col-md-offset-2 col-md-3">{input}{label}</div><div class="col-md-7">{error}</div>',
    ])->checkbox() ?>

    <div class="form-group">
        <div class="col-md-offset-2 col-md-12">
            <?= Html::submitButton('登录', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
            <?= Html::a('忘记密码', ['/user/secure/forgot-password'], ['class' => 'btn btn-danger']) ?>
        </div>
    </div>

    <?php HuActiveForm::end(); ?>

</div>
