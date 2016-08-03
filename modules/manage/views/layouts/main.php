<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\assets\ManageAssets;
use app\modules\core\helpers\UserHelper;
use mdm\admin\components\MenuHelper;
use yii\bootstrap\Alert;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;

ManageAssets::register($this);

$assignedMenu = MenuHelper::getAssignedMenu(UserHelper::getUserId());
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => '网站后台',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);

    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-left'],
        'items' => $assignedMenu,
    ]);

    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => [
            ['label' => '返回前台', 'url' => Yii::$app->homeUrl],
            ['label' => '登出(' . UserHelper::getUserName() . ')', 'url' => ['/logout']],
        ],
    ]);

    NavBar::end();
    ?>
    <div class="container">
        <div class="row">
            <div class="col-md-3 col-lg-2 hidden-sm hidden-xs">
                <div class="list-group" id="nav-menu">
                    <?php
                    /**
                     * TODO 目前输出菜单的代码只能支持到二级，以后再尝试解决这个问题。
                     */
                    $currentUrl = explode('?', Url::current())[0];
                    $currentUrlSnippet = explode('/', $currentUrl);
                    $currentUrlPath = '/' . $currentUrlSnippet[1] . '/' . $currentUrlSnippet[2];

                    $activeMenu = '';
                    foreach ($assignedMenu as $menuKey => $menuValue) {
                        $menuUrl = $menuValue['url'][0];

                        //提升体验
                        if ($menuUrl == '#') {
                            $menuUrl = 'javascript:void(0)';
                        }

                        //高亮一级菜单
                        if ($currentUrl == $menuUrl) {
                            $active = ' active';
                        } else {
                            $active = '';
                        }

                        echo Html::a($menuValue['label'], $menuUrl, [
                            'class' => 'list-group-item' . $active,
                            'data-toggle' => 'collapse',
                            'data-parent' => '#nav-menu',
                            'data-target' => '#nav-menu-' . $menuKey,
                        ]);

                        if (isset($menuValue['items'])) {
                            echo Html::beginTag('div', [
                                'id' => 'nav-menu-' . $menuKey,
                                'class' => 'submenu collapse',
                            ]);
                            foreach ($menuValue['items'] as $itemKey => $itemValue) {
                                $itemUrl = $itemValue['url'][0];
                                $itemUrlSnippet = explode('/', $itemUrl);
                                $itemUrlPath = '/' . $itemUrlSnippet[1] . '/' . $itemUrlSnippet[2];

                                //高亮一级菜单
                                if ($currentUrlPath == $itemUrlPath) {
                                    $activeMenu = 'nav-menu-' . $menuKey;
                                }

                                //高亮子链接
                                if ($currentUrl == $itemUrl) {
                                    $active = ' active';
                                } else {
                                    $active = '';
                                }

                                echo Html::a($itemValue['label'], $itemUrl, [
                                    'class' => 'list-group-item' . $active,
                                ]);
                            }
                            echo Html::endTag('div');
                        }
                    }
                    if ($activeMenu) {
                        ?>
                        <script>
                            var active_menu = $("[data-target = '#<?=$activeMenu ?>']");
                            active_menu.attr("class", active_menu.attr("class") + " active");
                            var active_menu_group = $("#<?=$activeMenu ?>");
                            active_menu_group.attr("class", active_menu_group.attr("class") + " in");
                        </script>
                        <?php
                    }
                    ?>
                </div>
            </div>
            <div class="col-md-9 col-lg-10">
                <?php
                echo Breadcrumbs::widget([
                    'homeLink' => [
                        'label' => '首页',
                        'url' => '/manage'
                    ],
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                ]);

                //获取成功消息提示
                if (Yii::$app->session->hasFlash('success')) {
                    echo Alert::widget([
                        'options' => ['class' => 'alert-success'],
                        'body' => Yii::$app->session->getFlash('success'),
                    ]);
                }
                //获取消息提示
                if (Yii::$app->session->hasFlash('info')) {
                    echo Alert::widget([
                        'options' => ['class' => 'alert-info'],
                        'body' => Yii::$app->session->getFlash('info'),
                    ]);
                }
                //获取错误消息提示
                if (Yii::$app->session->hasFlash('error')) {
                    echo Alert::widget([
                        'options' => ['class' => 'alert-danger'],
                        'body' => Yii::$app->session->getFlash('error'),
                    ]);
                }
                ?>

                <?= $content ?>

            </div>
        </div>
    </div>
</div>
<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; LaoHu Yii2 <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
