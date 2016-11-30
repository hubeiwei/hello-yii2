<?php

/**
 * @var $this yii\web\View
 * @var $content string
 */

use app\common\helpers\UserHelper;
use yii\widgets\Menu;

$this->beginContent('@app/views/layouts/frontend.php');
?>
    <div class="row">
        <div class="col-md-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <?= UserHelper::getUserName() ?>
                    </h3>
                </div>
                <div class="panel-body">
                    <?= Menu::widget([
                        'options' => [
                            'class' => 'nav nav-pills nav-stacked'
                        ],
                        'items' => [
                            ['label' => '个人资料',  'url' => ['/user/setting/detail']],
                        ],
                    ]) ?>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="panel panel-default">
                <div class="panel-body">
                    <?= $content ?>
                </div>
            </div>
        </div>
    </div>
<?php $this->endContent(); ?>
