<?php
/**
 * Created by PhpStorm.
 * User: HBW
 * Date: 2016/5/9
 * Time: 18:08
 * To change this template use File | Settings | File Templates.
 */

use app\modules\core\extensions\HuActiveForm;
use app\modules\core\extensions\HuCaptcha;
use kartik\password\PasswordInput;
use yii\helpers\Html;

/**
 * @var $this yii\web\View
 * @var $model app\modules\user\models\RegisterForm
 */

$this->title = '快速注册';
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-register">

    <?php $form = HuActiveForm::begin(); ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'password')->widget(PasswordInput::className(), ['options' => ['maxlength' => 20]]) ?>

    <?= $form->field($model, 'password_repeat')->passwordInput(['maxlength' => 20]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'verifyCode')->widget(HuCaptcha::className()) ?>

    <div class="form-group">
        <div class="col-md-offset-2 col-md-12">
            <?= Html::submitButton('提交', ['class' => 'btn btn-primary']) ?>
        </div>
    </div>

    <?php HuActiveForm::end(); ?>

</div>
