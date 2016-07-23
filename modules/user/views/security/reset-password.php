<?php

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
        <div class="col-lg-5">

            <?php $form = ActiveForm::begin(); ?>

            <?= $form->field($model, 'password')->passwordInput() ?>

            <div class="form-group">
                <?= Html::submitButton('提交', ['class' => 'btn btn-primary']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
