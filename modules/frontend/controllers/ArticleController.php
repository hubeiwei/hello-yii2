<?php

namespace app\modules\frontend\controllers;

use app\common\helpers\Message;
use app\common\helpers\UserHelper;
use app\models\Article;
use app\models\search\ArticleSearch;
use app\modules\frontend\controllers\base\ModuleController;
use app\modules\frontend\models\ArticleValidator;
use Yii;
use yii\base\ErrorException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;

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
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => [
                            'index',
                            'view-article',
                        ],
                    ],
                    [
                        'allow' => true,
                        'actions' => [
                            'my-article',
                            'view',
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

    public function actionIndex()
    {
        $searchModel = new ArticleSearch();
        $searchModel->scenario = ArticleSearch::SCENARIO_INDEX;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize = 15;
        $dataProvider->sort->defaultOrder = array_merge(
            $dataProvider->sort->defaultOrder,
            ['published_at' => SORT_DESC]
        );

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionMyArticle()
    {
        $this->layout = '@app/views/layouts/user';

        $searchModel = new ArticleSearch();
        $searchModel->scenario = ArticleSearch::SCENARIO_MY_ARTICLE;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('my-article', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

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

    public function actionCreate()
    {
        $request = Yii::$app->request;
        $model = new Article();
        $validator = new ArticleValidator();
        $model->type = $request->get('type', Article::TYPE_MARKDOWN);

        if ($request->isPost) {
            $data = $request->post();
            if (!UserHelper::isAdmin()) {
                // 因为设计的问题，不想改写rules，所以这样防止status被管理员之外的人修改
                unset($data[$model->formName()]['status']);
            }

            $model->load($data);
            $validator->load($data);
            if ($validator->validate()) {
                $model->published_at = strtotime($validator->published_at);
                if ($model->save()) {
                    Message::setSuccessMsg('发布成功');
                    return $this->redirect(['view', 'id' => $model->id]);
                } else {
                    Message::setErrorMsg('发布失败');
                }
            }
        } else {
            $validator->published_at = date('Y-m-d H:i');
        }

        return $this->render('create', [
            'model' => $model,
            'validator' => $validator,
        ]);
    }

    public function actionUpdate($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);

        if (!UserHelper::isBelongToUser($model->created_by)) {
            Message::setErrorMsg('不可修改其他人的数据');
            return $this->redirect(['index']);
        }

        $validator = new ArticleValidator();

        if ($request->isPost) {
            $data = $request->post();
            if (!UserHelper::isAdmin()) {
                // 因为设计的问题，不想改写rules，所以这样防止status被管理员之外的人修改
                unset($data[$model->formName()]['status']);
            }
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

        return $this->render('update', [
            'model' => $model,
            'validator' => $validator,
        ]);
    }

    /**
     * 为了适应grid是否开启pjax而这样写的，
     * 有个坑，要用ajax来判断，
     * 代码写两遍算是方便以后分别调整吧
     *
     * @param $id
     * @return \yii\web\Response
     * @throws ErrorException
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        if (!Yii::$app->request->isAjax) {
            if (UserHelper::isBelongToUser($model->created_by)) {
                if ($model->delete()) {
                    Message::setSuccessMsg('删除成功');
                } else {
                    Message::setErrorMsg('删除失败');
                }
            } else {
                Message::setErrorMsg('不能删除其他人的数据');
            }
            return $this->redirect(['my-article']);
        } else {
            if (UserHelper::isBelongToUser($model->created_by)) {
                if (!$model->delete()) {
                    throw new ErrorException('删除失败');
                }
            } else {
                throw new ErrorException('不能删除其他人的数据');
            }
        }
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
