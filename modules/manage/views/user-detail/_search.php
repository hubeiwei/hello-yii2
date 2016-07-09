<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var $this yii\web\View
 * @var $model app\models\search\UserDetailSearch
 * @var $form yii\widgets\ActiveForm
*/
?>

<div class="user-detail-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'user_id') ?>

    <?= $form->field($model, 'avatar_file') ?>

    <?= $form->field($model, 'gender') ?>

    <?= $form->field($model, 'birthday') ?>

    <?php // echo $form->field($model, 'email') ?>

    <?php // echo $form->field($model, 'phone') ?>

    <?php // echo $form->field($model, 'resume') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
