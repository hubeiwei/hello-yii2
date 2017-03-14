<?php

namespace app\modules\user\controllers;

use app\modules\user\controllers\base\ModuleController;
use app\modules\user\models\PasswordResetRequest;
use app\modules\user\models\ResetPassword;
use hubeiwei\yii2tools\helpers\Message;
use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;

class SecurityController extends ModuleController
{
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequest();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Message::setSuccessMsg('发送成功，请前往您的邮箱查看');
                return $this->goHome();
            } else {
                Message::setErrorMsg('对不起，重置密码邮件发送失败');
            }
        }

        return $this->render('request-password-reset', [
            'model' => $model,
        ]);
    }

    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPassword($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->getRequest()->post()) && $model->validate() && $model->resetPassword()) {
            Message::setSuccessMsg('密码修改成功');
            return $this->goHome();
        }

        return $this->render('reset-password', [
            'model' => $model,
        ]);
    }
}
