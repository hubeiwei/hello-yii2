<?php

namespace app\modules\core\controllers;

use app\modules\core\captcha\CaptchaAction;
use app\modules\core\controllers\base\ModuleController;
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
                'class' => CaptchaAction::className(),
            ],
        ];
    }
}
