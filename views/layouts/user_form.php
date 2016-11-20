<?php

/**
 * @var $this yii\web\View
 * @var $content string
 */

$this->beginContent('@app/views/layouts/frontend.php');
?>
<div class="row">
    <div class="col-md-3"></div>
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-body">
                <?= $content ?>
            </div>
        </div>
    </div>
    <div class="col-md-3"></div>
</div>
<?php $this->endContent(); ?>
