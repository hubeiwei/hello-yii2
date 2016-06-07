<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\assets\ManageAssets;
use app\modules\core\helpers\EasyHelper;
use app\modules\core\helpers\UserHelper;
use mdm\admin\components\MenuHelper;
use yii\bootstrap\Alert;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;

ManageAssets::register($this);
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
        'items' => MenuHelper::getAssignedMenu(UserHelper::getUserId()),
    ]);

    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => [
            ['label' => '返回前台', 'url' => Yii::$app->homeUrl],
            ['label' => '登出(' . UserHelper::getUserName() . ')', 'url' => ['/user/default/logout']],
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
                     * TODO 这种做法当currentUrl格式不是"/模块/控制器"的情况下会报错，需要把站点根目录部署为/web
                     */
                    $currentUrl = Url::current();
                    $currentUrlSnippet = explode('/', $currentUrl);
                    $currentUrlPath = '/' . $currentUrlSnippet[1] . '/' . $currentUrlSnippet[2];

                    $activeMenu = '';
                    $menu = MenuHelper::getAssignedMenu(UserHelper::getUserId());
                    foreach ($menu as $menuKey => $menuValue) {
                        $menuUrl = $menuValue['url'][0];

                        //提升体验
                        if ($menuUrl == '#') {
                            $menuUrl = 'javascript:void(0)';
                        }

                        //控制样式
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

                                //高亮父级菜单，根据url上的"/模块/控制器"来判断
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

                if (EasyHelper::hasMessage('success')) {
                    echo Alert::widget([
                        'options' => ['class' => 'alert-success'],
                        'body' => EasyHelper::getMessage('success'),
                    ]);
                }
                if (EasyHelper::hasMessage('info')) {
                    echo Alert::widget([
                        'options' => ['class' => 'alert-info'],
                        'body' => EasyHelper::getMessage('info'),
                    ]);
                }
                if (EasyHelper::hasMessage('error')) {
                    echo Alert::widget([
                        'options' => ['class' => 'alert-danger'],
                        'body' => EasyHelper::getMessage('error'),
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
        <p class="pull-left">&copy; Easy Music <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
