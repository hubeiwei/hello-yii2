<?php

namespace app\modules\manage\controllers;

use app\models\search\UserDetailSearch;
use app\models\UserDetail;
use app\modules\core\helpers\EasyHelper;
use app\modules\manage\controllers\base\ModuleController;
use app\modules\user\models\UserDetailForm;
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
        $model = $this->findModel($id);
        $form = new UserDetailForm();

        if ($form->load(Yii::$app->request->post())) {
            if ($form->validate()) {
                $model->setAttributes($form->getAttributes());
                $model->birthday = $form->birthday ? strtotime($form->birthday) : null;
                if ($model->save()) {
                    EasyHelper::setSuccessMsg('修改成功');
                    return $this->redirect(['view', 'id' => $model->id]);
                } else {
                    $form->addErrors($model->getErrors());
                }
            }
        } else {
            $form->setAttributes($model->getAttributes());
            $form->birthday = EasyHelper::timestampToDate($model->birthday, 'Y-m-d');
        }

        return $this->render('update', [
            'id' => $model->id,
            'username' => $model->user->username,
            'model' => $form,
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
