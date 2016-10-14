<?php

namespace app\modules\core\controllers;

use app\modules\core\controllers\base\ModuleController;
use app\modules\core\extensions\HuCaptchaAction;
use yii\web\ErrorAction;

class DefaultController extends ModuleController
{
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => ErrorAction::className(),
                'view' => '@app/views/site/error.php',
            ],
            'captcha' => [
                'class' => HuCaptchaAction::className(),
            ],
        ];
    }
}
