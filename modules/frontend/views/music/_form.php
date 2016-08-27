<?php

use app\models\Music;
use app\modules\core\extensions\HuCaptcha;
use app\modules\core\helpers\UserHelper;
use kartik\file\FileInput;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var $this yii\web\View
 * @var $model app\modules\frontend\models\MusicForm
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

    <?= $form->field($model, 'music_file')->widget(FileInput::className(), [
        'pluginOptions' => [
            'showUpload' => false,//不显示上传按钮，这个按钮是submit
            'browseLabel' => '',
            'removeLabel' => '',
        ],
        'options' => [
            'accept' => 'audio/mpeg',
        ],
    ])->label($model->scenario == 'update' ? '新文件（可不传）' : '文件') ?>

    <?= $form->field($model, 'visible')->dropDownList(Music::$visible_map) ?>

    <?php
    if (UserHelper::isAdmin()) {
        echo $form->field($model, 'status')->dropDownList(Music::$status_map);
    }
    ?>

    <?= $form->field($model, 'verifyCode')->widget(HuCaptcha::className()) ?>

    <div class="form-group">
        <?= Html::submitButton('提交', ['class' => 'btn btn-primary btn-block']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
