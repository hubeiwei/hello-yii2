<?php
/**
 * Created by PhpStorm.
 * User: hubeiwei
 * Date: 2016/8/2
 * Time: 18:27
 * To change this template use File | Settings | File Templates.
 */

/**
 * @var $this yii\web\View
 * @var $content string
 */

$this->beginContent('@app/modules/manage/views/layouts/main.php');
?>

<div class="row">
    <div class="col-md-5">
        <?= $content ?>
    </div>
</div>

<?php $this->endContent(); ?>
