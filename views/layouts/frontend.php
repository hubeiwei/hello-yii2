<?php

use hubeiwei\yii2tools\widgets\CssBlock;
use hubeiwei\yii2tools\widgets\Growl;
use yii\widgets\Breadcrumbs;

/**
 * @var $this \yii\web\View
 * @var $content string
 */

?>

<?php CssBlock::begin(); ?>
<style>
    html, body {
        background-color: #f1f1f1;
    }
</style>
<?php CssBlock::end(); ?>

<?php $this->beginContent('@app/views/layouts/master.php') ?>

<?= $this->render('@app/views/include/frontend_nav.php') ?>

<div class="container">
    <?= Breadcrumbs::widget([
        'homeLink' => false,
        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        'options' => [
            'class' => 'breadcrumb',
            'style' => [
                'background-color' => 'white',
            ],
        ],
    ]) ?>

    <?= Growl::widget() ?>

    <?= $content ?>
</div>
<?php $this->endContent(); ?>
