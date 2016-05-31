<?php

use app\models\UserDetail;
use app\modules\core\extensions\HuActiveForm;
use app\modules\core\extensions\HuCaptcha;
use kartik\date\DatePicker;
use yii\helpers\Html;

/**
 * @var $this yii\web\View
 * @var $form HuActiveForm
 * @var $model UserDetail
 * @var $user_detail_form app\modules\user\models\UserDetailForm
 */

$this->title = '用户资料: ' . $model->user->username;
$this->params['breadcrumbs'][] = ['label' => '用户资料', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->user->username, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = '修改';
?>
<div class="user-detail-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <hr>

    <div class="user-detail-form">

        <?php
        $form = HuActiveForm::begin();

        echo $form->field($user_detail_form, 'gender')->dropDownList(UserDetail::$gender_map);

        echo $form->field($user_detail_form, 'birthday')->widget(DatePicker::className(), [
            'pluginOptions' => [
                'autoclose' => true,
                'format' => 'yyyy-mm-dd',
            ],
        ]);

        echo $form->field($user_detail_form, 'email')->textInput(['maxlength' => true]);

        echo $form->field($user_detail_form, 'phone')->textInput(['maxlength' => 11]);

        echo $form->field($user_detail_form, 'resume')->textarea(['maxlength' => 100, 'rows' => 3]);

        echo $form->field($user_detail_form, 'verifyCode')->widget(HuCaptcha::className());
        ?>

        <div class="form-group">
            <div class="col-md-offset-2 col-md-12">
                <?= Html::submitButton('修改', ['class' => 'btn btn-primary']) ?>
            </div>
        </div>

        <?php HuActiveForm::end(); ?>

    </div>

</div>
