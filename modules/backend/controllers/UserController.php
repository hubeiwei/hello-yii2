<?php

namespace app\modules\backend\controllers;

use app\models\search\UserSearch;
use app\models\User;
use app\models\UserDetail;
use app\modules\backend\controllers\base\ModuleController;
use hubeiwei\yii2tools\helpers\Helper;
use hubeiwei\yii2tools\helpers\Message;
use Yii;
use yii\base\ErrorException;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends ModuleController
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
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $user = new User();

        if ($user->load(Yii::$app->request->post())) {

            $transaction = Helper::beginTransaction();
            $flow = $user->save(false);
            if ($flow) {
                $user_detail = new UserDetail();
                $user_detail->user_id = $user->id;
                $flow = $user_detail->save();
            }
            if ($flow) {
                $transaction->commit();
                Message::setSuccessMsg('添加成功');
                return $this->redirect(['view', 'id' => $user->id]);
            } else {
                $transaction->rollBack();
                Message::setErrorMsg('添加失败');
            }
        }

        return $this->render('create', [
            'model' => $user,
        ]);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                Message::setSuccessMsg('修改成功');
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * 为了适应grid是否开启pjax而这样写的，
     * 有个坑，要用ajax来判断，
     *
     * @param $id
     * @return \yii\web\Response
     * @throws ErrorException
     */
    public function actionDelete($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);
        $userDetail = UserDetail::findOne(['user_id' => $id]);

        $transaction = Helper::beginTransaction();
        if ($model->delete() && $userDetail->delete()) {
            $transaction->commit();
            if (!$request->isAjax) {
                Message::setSuccessMsg('删除成功');
            }
        } else {
            $transaction->rollBack();
            if (!$request->isAjax) {
                Message::setErrorMsg('删除失败');
            } else {
                throw new ErrorException('删除失败');
            }
        }

        if (!$request->isAjax) {
            return $this->redirect(['index']);
        }
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
