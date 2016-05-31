<?php
/**
 * Created by PhpStorm.
 * User: HBW
 * Date: 2016/5/9
 * Time: 18:08
 * To change this template use File | Settings | File Templates.
 */

//use app\modules\core\helpers\UserHelper;
use app\modules\core\extensions\HuActiveForm;
use app\modules\core\extensions\HuCaptcha;
use kartik\password\PasswordInput;
//use kartik\widgets\Typeahead;
use yii\helpers\Html;

/**
 * @var $this yii\web\View
 * @var $model app\modules\user\models\RegisterForm
 */

$this->title = '快速注册';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-register">

    <h1><?= Html::encode($this->title) ?></h1>

    <hr>

    <?php
    $form = HuActiveForm::begin();

    echo $form->field($model, 'username')->textInput(['maxlength' => true]);

    echo $form->field($model, 'password')->widget(PasswordInput::className(), ['options' => ['maxlength' => 20]]);

    echo $form->field($model, 'password_repeat')->passwordInput(['maxlength' => 20]);

    echo $form->field($model, 'email')->textInput(['maxlength' => true]);

//    echo $form->field($model, 'security_question')->widget(Typeahead::className(), [
//        'options' => ['maxlength' => 32],
//        'defaultSuggestions' => UserHelper::$questions,
//        'pluginOptions' => ['highlight'=>true],
//        'dataset' => [
//            [
//                'local' => UserHelper::$questions,
//                'limit' => 10
//            ]
//        ],
//    ]);
//
//    echo $form->field($model, 'security_answer')->textInput(['maxlength' => true]);

    echo $form->field($model, 'verifyCode')->widget(HuCaptcha::className());
    ?>

    <div class="form-group">
        <div class="col-md-offset-2 col-md-12">
            <?= Html::submitButton('提交', ['class' => 'btn btn-primary']) ?>
        </div>
    </div>

    <?php HuActiveForm::end(); ?>

</div>
