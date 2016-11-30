<?php

namespace app\modules\user\controllers;

use app\common\helpers\Message;
use app\common\helpers\UserHelper;
use app\models\UserDetail;
use app\modules\user\controllers\base\ModuleController;
use app\modules\user\models\UserDetailForm;
use Yii;
use yii\filters\AccessControl;

class SettingController extends ModuleController
{
    public $defaultAction = 'detail';

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => [
                            'detail',
                        ],
                        'roles' => ['@'],
                    ],
                ],
                'denyCallback' => function ($rule, $action) {
                    return $this->goHome();
                },
            ],
        ];
    }

    public function actionDetail()
    {
        $model = UserDetail::findOne(['user_id' => UserHelper::getUserId()]);
        $form = new UserDetailForm();

        if ($form->load(Yii::$app->request->post())) {
            if ($form->validate()) {
                $model->setAttributes($form->getAttributes());
                $model->birthday = $form->birthday ? strtotime($form->birthday) : null;
                if ($model->save()) {
                    Message::setSuccessMsg('修改成功');
                    return $this->redirect(['detail', 'id' => $model->id]);
                } else {
                    Message::setErrorMsg('修改失败');
                    $form->addErrors($model->getErrors());
                }
            }
        } else {
            $form->setAttributes($model->getAttributes());
            $form->birthday = date('Y-m-d', $model->birthday);
        }

        return $this->render('detail', [
            'model' => $form,
        ]);
    }
}
