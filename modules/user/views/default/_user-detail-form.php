<?php
/**
 * Created by PhpStorm.
 * User: HBW
 * Date: 2016/6/10
 * Time: 3:35
 * To change this template use File | Settings | File Templates.
 */

use app\models\UserDetail;
use app\modules\core\extensions\HuActiveForm;
use app\modules\core\extensions\HuCaptcha;
use kartik\date\DatePicker;
use yii\helpers\Html;

/**
 * @var $this yii\web\View
 * @var $form HuActiveForm
 * @var $model app\modules\user\models\UserDetailForm
 */
?>

<div class="user-detail-form">

    <?php $form = HuActiveForm::begin(); ?>

    <?= $form->field($model, 'gender')->dropDownList(UserDetail::$gender_map) ?>

    <?= $form->field($model, 'birthday')->widget(DatePicker::className(), [
        'readonly' => true,
        'pluginOptions' => [
            'autoclose' => true,
            'format' => 'yyyy-mm-dd',
        ],
    ]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'phone')->textInput(['maxlength' => 11]) ?>

    <?= $form->field($model, 'resume')->textarea(['maxlength' => 100, 'rows' => 3]) ?>

    <?= $form->field($model, 'verifyCode')->widget(HuCaptcha::className()) ?>

    <div class="form-group">
        <div class="col-md-offset-2 col-md-12">
            <?= Html::submitButton('修改', ['class' => 'btn btn-primary']) ?>
        </div>
    </div>

    <?php HuActiveForm::end(); ?>

</div>
