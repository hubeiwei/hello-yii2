<?php

namespace app\modules\user\controllers;

use app\common\helpers\Message;
use app\common\helpers\UserHelper;
use app\models\UserDetail;
use app\modules\user\controllers\base\ModuleController;
use app\modules\user\models\UserDetailValidator;
use Yii;
use yii\filters\AccessControl;

class HomeController extends ModuleController
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
        $request = Yii::$app->request;
        $model = UserDetail::findOne(['user_id' => UserHelper::getUserId()]);
        $validator = new UserDetailValidator();

        if ($request->isPost) {
            $validator->load($request->post());
            $model->load($request->post());
            if ($validator->validate()) {
                $model->birthday = $validator->birthday ? strtotime($validator->birthday) : null;
                if ($model->save()) {
                    Message::setSuccessMsg('修改成功');
                    return $this->redirect(['detail']);
                } else {
                    Message::setErrorMsg('修改失败');
                }
            }
        } else {
            $validator->birthday = $model->birthday ? date('Y-m-d', $model->birthday) : null;
        }

        return $this->render('detail', [
            'model' => $model,
            'validator' => $validator,
        ]);
    }
}
