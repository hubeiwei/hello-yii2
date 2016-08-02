<?php
/**
 * Created by PhpStorm.
 * User: HBW
 * Date: 2016/5/9
 * Time: 18:08
 * To change this template use File | Settings | File Templates.
 */

use app\modules\core\extensions\HuCaptcha;
use kartik\password\PasswordInput;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var $this yii\web\View
 * @var $model app\modules\user\models\RegisterForm
 */

$this->title = '快速注册';
?>
<div class="site-register">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'username')->textInput([
        'autofocus' => true,
        'maxlength' => true,
    ]) ?>

    <?= $form->field($model, 'password')->widget(PasswordInput::className(), ['options' => ['maxlength' => 20]]) ?>

    <?= $form->field($model, 'password_repeat')->passwordInput(['maxlength' => 20]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'verifyCode')->widget(HuCaptcha::className()) ?>

    <?= Html::submitButton('提交', ['class' => 'btn btn-primary']) ?>

    <?php ActiveForm::end(); ?>

</div>
