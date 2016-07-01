<?php
/**
 * Created by PhpStorm.
 * User: HBW
 * Date: 2016/5/24
 * Time: 11:52
 * To change this template use File | Settings | File Templates.
 */

namespace app\modules\user\controllers;

use app\modules\core\helpers\EasyHelper;
use app\modules\user\controllers\base\ModuleController;

class SecureController extends ModuleController
{
    public function actionForgotPassword()
    {
        EasyHelper::setMessage('开发中，暂未开放');
        return $this->redirect(['/user/default/login']);
    }
}
