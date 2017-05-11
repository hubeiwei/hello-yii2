<?php

use app\common\captcha\Captcha;
use app\common\helpers\UserHelper;
use app\models\Music;
use kartik\file\FileInput;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var $this yii\web\View
 * @var $model app\models\Music
 * @var $validator app\modules\frontend\models\MusicValidator
 */
?>

<div class="music-form">

    <?php
    /**
     * Yii2.0.8如果用了$form->field()->fileInput()，会自动生成enctype="multipart/form-data"
     * 现在用了kartik\file\FileInput，得自己写
     */
    $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data'],
    ]);
    ?>

    <?= $form->field($model, 'track_title')->textInput([
        'autofocus' => true,
        'maxlength' => true,
    ]) ?>

    <?= $form->field($validator, 'music_file')->widget(FileInput::className(), [
        'options' => [
            'accept' => 'audio/mpeg',
        ],
        'pluginOptions' => [
            'showUpload' => false,//不显示上传按钮，这个按钮是submit
            'browseLabel' => '',
            'removeLabel' => '',
        ],
    ])->label($model->isNewRecord ? '文件' : '新文件（可不传）') ?>

    <?= $form->field($model, 'visible')->dropDownList(Music::visibleMap()) ?>

    <?php
    if (UserHelper::isAdmin()) {
        echo $form->field($model, 'status')->dropDownList(Music::statusMap());
    }
    ?>

    <?= $form->field($validator, 'verifyCode')->widget(Captcha::className()) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '添加' : '修改', [
            'class' => [
                'btn',
                $model->isNewRecord ? 'btn-success' : 'btn-primary',
                'btn-block',
            ],
        ]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
