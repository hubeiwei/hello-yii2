<?php

namespace app\modules\portal\controllers;

use app\models\Article;
use app\models\search\ArticleSearch;
use app\modules\core\helpers\EasyHelper;
use app\modules\core\helpers\UserHelper;
use app\modules\portal\controllers\base\ModuleController;
use app\modules\portal\models\ArticleForm;
use Yii;
use yii\filters\AccessControl;
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
            'access' => [
                'class' => AccessControl::className(),
                'only' => [
                    'index',
                    'my-article',
                    'create',
                    'update',
                    'delete',
                ],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => [
                            'index',
                        ],
                    ],
                    [
                        'allow' => true,
                        'actions' => [
                            'my-article',
                            'create',
                            'update',
                            'delete',
                        ],
                        'roles' => ['@'],
                    ],
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

    public function actionMyArticle()
    {
        $searchModel = new ArticleSearch();
        $dataProvider = $searchModel->searchMyArticle(Yii::$app->request->queryParams);

        return $this->render('my-article', [
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
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionViewArticle($id)
    {
        return $this->render('view-article', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Article model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $this->layout = '@app/views/layouts/form';

        $form = new ArticleForm();
        $form->type = Yii::$app->request->get('type', Article::TYPE_MARKDOWN);

        if ($form->load(Yii::$app->request->post())) {
            if ($form->validate()) {
                $model = new Article();
                $model->setAttributes($form->getAttributes());
                $model->published_at = strtotime($form->published_at);
                if ($model->save(false)) {
                    EasyHelper::setSuccessMsg('发布成功');
                    return $this->redirect(['view', 'id' => $model->id]);
                } else {
                    EasyHelper::setErrorMsg('发布失败');
                }
            }
        } else {
            $form->published_at = date('Y-m-d H:i');
        }

        return $this->render('create', [
            'model' => $form,
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
        $this->layout = '@app/views/layouts/form';

        $model = $this->findModel($id);

        if (!UserHelper::isBelongToUser($model->created_by)) {
            EasyHelper::setErrorMsg('不可修改其他人的数据');
            return $this->redirect(['index']);
        }

        $form = new ArticleForm();

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
            $form->published_at = date('Y-m-d H:i', $model->published_at);
        }

        return $this->render('update', [
            'model' => $form,
            'id' => $model->id,
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

        if (UserHelper::isBelongToUser($model->created_by)) {
            if ($model->delete()) {
                EasyHelper::setSuccessMsg('删除成功');
            } else {
                EasyHelper::setErrorMsg('删除失败');
            }
        } else {
            EasyHelper::setErrorMsg('不能删除其他人的数据');
        }

        return $this->redirect(['my-article']);
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
