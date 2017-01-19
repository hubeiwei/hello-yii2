<?php

use app\assets\AppAsset;

/**
 * @var $this \yii\web\View
 * @var $content string
 */

AppAsset::register($this);
$this->registerMetaTag([
    'name' => 'viewport',
    'content' => 'width=device-width, initial-scale=1, user-scalable=no',
]);
?>
<?php $this->beginContent('@app/views/layouts/base_html5.php') ?>
<div class="wrap">
    <?= $content ?>
</div>
<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; <?= Yii::$app->name . ' ' . date('Y') ?></p>
        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>
<?php $this->endContent(); ?>
