<?php

/**
 * @var $this \yii\web\View
 * @var $content string
 */

$this->beginContent('@app/views/layouts/master.php');
?>

<div class="panel panel-default">
    <div class="panel-body">
        <?= $content ?>
    </div>
</div>

<?php $this->endContent(); ?>
