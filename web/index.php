<?php

// comment out the following two lines when deployed to production
if (isset($_SERVER['HTTP_LaoHu']) || strpos($_SERVER['SERVER_ADDR'], '127.0') === 0 || strpos($_SERVER['SERVER_ADDR'], '192.168') === 0
) {
    defined('YII_DEBUG') or define('YII_DEBUG', true);
    defined('YII_ENV') or define('YII_ENV', 'dev');
} else {
    defined('YII_DEBUG') or define('YII_DEBUG', false);
    defined('YII_ENV') or define('YII_ENV', 'prod');
}

require(__DIR__ . '/../vendor/autoload.php');
require(__DIR__ . '/../vendor/yiisoft/yii2/Yii.php');

$config = require(__DIR__ . '/../config/web.php');

(new yii\web\Application($config))->run();
