<?php

use app\models\Music;
use app\modules\core\extensions\HuActiveForm;
use app\modules\core\extensions\HuCaptcha;
use app\modules\core\helpers\UserHelper;
use kartik\file\FileInput;
use yii\helpers\Html;

/**
 * @var $this yii\web\View
 * @var $model app\modules\portal\models\MusicForm
 * @var $form HuActiveForm
 */
?>

<div class="music-form">

    <?php
    /**
     * Yii2.0.8如果用了$form->field()->fileInput()，会自动生成enctype="multipart/form-data"
     * 现在用了kartik\file\FileInput，得自己写
     */
    $form = HuActiveForm::begin([
        //options覆盖了，得重新配class
        'options' => ['class' => 'form-horizontal', 'enctype' => 'multipart/form-data'],
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
    if (UserHelper::userIsAdmin()) {
        echo $form->field($model, 'status')->dropDownList(Music::$status_map);
    }
    ?>

    <?= $form->field($model, 'verifyCode')->widget(HuCaptcha::className()) ?>

    <div class="form-group">
        <div class="col-md-offset-2 col-md-12">
            <?= Html::submitButton('提交', ['class' => 'btn btn-primary']) ?>
        </div>
    </div>

    <?php HuActiveForm::end(); ?>

</div>
