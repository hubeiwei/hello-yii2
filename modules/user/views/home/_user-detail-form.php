<?php

use app\common\captcha\Captcha;
use app\models\UserDetail;
use kartik\date\DatePicker;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var $this yii\web\View
 * @var $model app\models\UserDetail
 * @var $validator app\modules\user\models\UserDetailValidator
 */
?>

<div class="user-detail-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'gender')->dropDownList(UserDetail::genderMap()) ?>

    <?= $form->field($validator, 'birthday')->widget(DatePicker::className(), [
        'pluginOptions' => [
            'autoclose' => true,
            'format' => 'yyyy-mm-dd',
        ],
    ]) ?>

    <?= $form->field($model, 'phone')->textInput(['maxlength' => 11]) ?>

    <?= $form->field($model, 'resume')->textarea(['maxlength' => 100, 'rows' => 3]) ?>

    <?= $form->field($validator, 'verifyCode')->widget(Captcha::className()) ?>

    <div class="form-group">
        <?= Html::submitButton('保存', ['class' => 'btn btn-primary btn-block']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
