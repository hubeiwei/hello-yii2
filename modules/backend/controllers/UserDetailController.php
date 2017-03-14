<?php

namespace app\modules\backend\controllers;

use app\models\search\UserDetailSearch;
use app\models\UserDetail;
use app\modules\backend\controllers\base\ModuleController;
use app\modules\user\models\UserDetailValidator;
use hubeiwei\yii2tools\helpers\Message;
use Yii;
use yii\web\NotFoundHttpException;

/**
 * UserDetailController implements the CRUD actions for UserDetail model.
 */
class UserDetailController extends ModuleController
{
    /**
     * Lists all UserDetail models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserDetailSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single UserDetail model.
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
     * Updates an existing UserDetail model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);
        $validator = new UserDetailValidator();

        if ($request->isPost) {
            $validator->load($request->post());
            $model->load($request->post());
            if ($validator->validate()) {
                $model->birthday = $validator->birthday ? strtotime($validator->birthday) : null;
                if ($model->save()) {
                    Message::setSuccessMsg('修改成功');
                    return $this->redirect(['view', 'id' => $model->id]);
                } else {
                    Message::setErrorMsg('修改失败');
                }
            }
        } else {
            $validator->birthday = $model->birthday ? date('Y-m-d', $model->birthday) : null;
        }

        return $this->render('update', [
            'model' => $model,
            'validator' => $validator,
        ]);
    }

    /**
     * Finds the UserDetail model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return UserDetail the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = UserDetail::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
