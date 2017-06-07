<?php

namespace app\modules\user\controllers;

use app\modules\user\controllers\base\ModuleController;
use app\modules\user\models\LoginForm;
use app\modules\user\models\RegisterForm;
use hubeiwei\yii2tools\helpers\Message;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\User;

class DefaultController extends ModuleController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['POST'],
                ],
            ],
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
            Yii::$app->user->on(User::EVENT_BEFORE_LOGIN, function ($event) {
                /** @var \yii\web\UserEvent $event */
                /** @var \app\models\User $user */
                $user = $event->identity;
                $flow = true;
                if ($flow && !$user->refreshAuthKey()) {
                    $flow = false;
                }
                $event->isValid = $flow;
            });
            if ($model->login()) {
                Message::setSuccessMsg('登录成功');
                return $this->goHome();
            } else {
                Message::setErrorMsg('登录失败');
            }
        }

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();
        Message::setMessage('已登出');
        return $this->goHome();
    }

    public function actionRegister()
    {
        $form = new RegisterForm();

        if ($form->load(Yii::$app->request->post())) {
            if ($form->register()) {
                Message::setSuccessMsg('注册成功');
                return $this->redirect('login');
            } else {
                Message::setErrorMsg('注册失败');
            }
        }

        return $this->render('register', [
            'model' => $form
        ]);
    }
}
