<?php

namespace app\modules\manage\controllers;

use app\models\Article;
use app\models\search\ArticleSearch;
use app\modules\core\helpers\EasyHelper;
use app\modules\manage\controllers\base\ModuleController;
use app\modules\portal\models\ArticleForm;
use Yii;
use yii\web\NotFoundHttpException;

/**
 * ArticleController implements the CRUD actions for Article model.
 */
class ArticleController extends ModuleController
{
    public function actionIndex()
    {
        $searchModel = new ArticleSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        return $this->render('@app/modules/portal/views/article/view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $form = new ArticleForm();
        $form->type = $model->type;
        $form->isNewRecord = false;

        if ($form->load(Yii::$app->request->post())) {
            if ($form->validate()) {
                $model->setAttributes($form->getAttributes());
                $model->published_at = strtotime($form->published_at);
                if ($model->save()) {
                    EasyHelper::setSuccessMsg('修改成功');
                    return $this->redirect(['view', 'id' => $model->id]);
                } else {
                    EasyHelper::setErrorMsg('修改失败');
                }
            }
        } else {
            $form->setAttributes($model->getAttributes());
        }

        return $this->render('@app/modules/portal/views/article/update', [
            'model' => $form,
            'id' => $model->id,
        ]);
    }

    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        if ($model->delete()) {
            EasyHelper::setSuccessMsg('删除成功');
        } else {
            EasyHelper::setErrorMsg('删除失败');
        }

        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = Article::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
