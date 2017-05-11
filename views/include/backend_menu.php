<?php

use kartik\sidenav\SideNav;

/**
 * @var $this yii\web\View
 * @var $menu array
 */

echo SideNav::widget([
    'items' => $menu,
]);
