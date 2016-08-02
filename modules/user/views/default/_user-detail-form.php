<?php
/**
 * Created by PhpStorm.
 * User: HBW
 * Date: 2016/6/10
 * Time: 3:35
 * To change this template use File | Settings | File Templates.
 */

use app\models\UserDetail;
use app\modules\core\extensions\HuCaptcha;
use kartik\date\DatePicker;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var $this yii\web\View
 * @var $model app\modules\user\models\UserDetailForm
 */
?>

<div class="user-detail-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'gender')->dropDownList(UserDetail::$gender_map) ?>

    <?= $form->field($model, 'birthday')->widget(DatePicker::className(), [
        'readonly' => true,
        'pluginOptions' => [
            'autoclose' => true,
            'format' => 'yyyy-mm-dd',
        ],
    ]) ?>

    <?= $form->field($model, 'phone')->textInput(['maxlength' => 11]) ?>

    <?= $form->field($model, 'resume')->textarea(['maxlength' => 100, 'rows' => 3]) ?>

    <?= $form->field($model, 'verifyCode')->widget(HuCaptcha::className()) ?>

    <?= Html::submitButton('修改', ['class' => 'btn btn-primary']) ?>

    <?php ActiveForm::end(); ?>

</div>
