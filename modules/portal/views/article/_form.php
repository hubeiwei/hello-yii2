<?php

use app\models\Article;
use app\modules\core\extensions\HuCaptcha;
use app\modules\core\helpers\UserHelper;
use ijackua\lepture\Markdowneditor;
use kartik\datetime\DateTimePicker;
use yii\helpers\Html;
use yii\redactor\widgets\Redactor;
use yii\widgets\ActiveForm;

/**
 * @var $this yii\web\View
 * @var $model app\modules\portal\models\ArticleForm
 * @var $form yii\widgets\ActiveForm
 */
?>

<div class="article-form">

    <?php
    $form = ActiveForm::begin();

    echo $form->field($model, 'title')->textInput(['maxlength' => true]);

    if ($model->type == Article::TYPE_MARKDOWN) {
        echo $form->field($model, 'content')->widget(Markdowneditor::className());
    } else if ($model->type == Article::TYPE_HTML) {
        echo $form->field($model, 'content')->widget(Redactor::className());
    }

    echo $form->field($model, 'published_at')->widget(DateTimePicker::className(), [
        'readonly' => true,
        'pluginOptions' => [
            'autoclose' => true,
        ],
    ]);

    echo $form->field($model, 'visible')->dropDownList(Article::$visible_map);

    echo $form->field($model, 'type', ['template' => '{input}'])->hiddenInput();

    if (UserHelper::userIsAdmin()) {
        echo $form->field($model, 'status')->dropDownList(Article::$status_map);
    }

    echo $form->field($model, 'verifyCode')->widget(HuCaptcha::className());

    ?>

    <div class="form-group">
        <?= Html::submitButton('提交', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
