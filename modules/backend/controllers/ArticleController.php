<?php

namespace app\modules\backend\controllers;

use app\common\helpers\Message;
use app\models\Article;
use app\models\search\ArticleSearch;
use app\modules\backend\controllers\base\ModuleController;
use app\modules\frontend\models\ArticleValidator;
use Yii;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;

/**
 * ArticleController implements the CRUD actions for Article model.
 */
class ArticleController extends ModuleController
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
     * Lists all Article models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ArticleSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Article model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('@app/modules/frontend/views/article/view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Updates an existing Article model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);
        $validator = new ArticleValidator();

        if ($request->isPost) {
            $data = $request->post();
            $model->load($data);
            $validator->load($data);
            if ($validator->validate()) {
                $model->published_at = strtotime($validator->published_at);
                if ($model->save()) {
                    Message::setSuccessMsg('修改成功');
                    return $this->redirect(['view', 'id' => $model->id]);
                } else {
                    Message::setErrorMsg('修改失败');
                }
            }
        } else {
            $validator->published_at = $model->published_at ? date('Y-m-d H:i', $model->published_at) : null;
        }

        return $this->render('@app/modules/frontend/views/article/update', [
            'model' => $model,
            'validator' => $validator,
        ]);
    }

    /**
     * Deletes an existing Article model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        if ($model->delete()) {
            Message::setSuccessMsg('删除成功');
        } else {
            Message::setErrorMsg('删除失败');
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the Article model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Article the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Article::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
