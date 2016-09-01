<?php

use app\assets\AppAsset;
use app\modules\core\helpers\UserHelper;
use mdm\admin\components\MenuHelper;
use yii\bootstrap\Alert;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;

/**
 * @var $this \yii\web\View
 * @var $content string
 */

$this->registerCssFile('@web/css/backend.css', ['depends' => AppAsset::className()]);

$this->beginContent('@app/views/layouts/master.php');

$assignedMenu = MenuHelper::getAssignedMenu(UserHelper::getUserId());

NavBar::begin([
    'brandLabel' => Yii::$app->name . '后台',
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
        ['label' => '返回前台', 'url' => ['/frontend']],
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
                 * TODO 只支持到二级
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
                        active_menu.addClass("active");
                        var active_menu_group = $("#<?=$activeMenu ?>");
                        active_menu_group.addClass("in");
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
                    'url' => ['/backend'],
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

            echo $content;
            ?>
        </div>
    </div>
</div>
<?php $this->endContent(); ?>
