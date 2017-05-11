<?php

use app\models\Setting;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var $this yii\web\View
 * @var $model Setting
 */
?>

<div class="setting-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'key')->textInput([
        'autofocus' => true,
        'maxlength' => true,
    ]) ?>

    <?= $form->field($model, 'value')->textarea(['rows' => 3]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6, 'maxlength' => true]) ?>

    <?= $form->field($model, 'tag')->textInput(['maxlength' => true, 'placeholder' => '用在哪个类或场景']) ?>

    <?= $form->field($model, 'status')->dropDownList(Setting::statusMap()) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '添加' : '修改', ['class' => 'btn btn-block ' . ($model->isNewRecord ? 'btn-success' : 'btn-primary')]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
