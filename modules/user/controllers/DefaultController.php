<?php

namespace app\modules\user\controllers;

use app\models\User;
use app\models\UserDetail;
use app\modules\core\helpers\EasyHelper;
use app\modules\core\helpers\UserHelper;
use app\modules\user\controllers\base\ModuleController;
use app\modules\user\models\LoginForm;
use app\modules\user\models\RegisterForm;
use app\modules\user\models\UserDetailForm;
use yii\filters\AccessControl;
use Yii;

class DefaultController extends ModuleController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => [
                            'login',
                            'register',
                        ],
                        'roles' => ['?'],
                    ],
                    [
                        'allow' => true,
                        'actions' => [
                            'logout',
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

    public function actionLogin()
    {
        $model = new LoginForm();

        if ($model->load(Yii::$app->request->post())) {
            if ($model->login()) {
                EasyHelper::setSuccessMsg('登录成功');
                return $this->goHome();
            } else {
                EasyHelper::setErrorMsg('登录失败');
            }
        }

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();
        EasyHelper::setMessage('已登出');
        return $this->goHome();
    }

    public function actionRegister()
    {
        $form = new RegisterForm();

        if ($form->load(Yii::$app->request->post())) {
            if ($form->validate()) {
                $user = new User();
                $user->setAttributes($form->getAttributes());
                $user->password_hash = $form->password;

                $transaction = EasyHelper::beginTransaction();
                $flow = $user->save(false);
                if ($flow) {
                    $user_detail = new UserDetail();
                    $user_detail->user_id = $user->id;
                    $flow = $user_detail->save(false);
                }
                if ($flow) {
                    $transaction->commit();
                    EasyHelper::setSuccessMsg('注册成功');
                    return $this->redirect('login');
                } else {
                    $transaction->rollBack();
                    EasyHelper::setErrorMsg('注册失败');
                }
            }
        }

        return $this->render('register', [
            'model' => $form
        ]);
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
                    EasyHelper::setSuccessMsg('修改成功');
                    return $this->redirect(['detail', 'id' => $model->id]);
                } else {
                    EasyHelper::setErrorMsg('修改失败');
                    $form->addErrors($model->getErrors());
                }
            }
        } else {
            $form->setAttributes($model->getAttributes());
            $form->birthday = EasyHelper::timestampToDate($model->birthday, 'Y-m-d');
        }

        return $this->render('detail', [
            'model' => $form,
        ]);
    }
}
