<?php

namespace app\modules\frontend\controllers;

use app\common\extensions\Query;
use app\common\helpers\Message;
use app\common\helpers\UserHelper;
use app\models\Article;
use app\models\search\ArticleSearch;
use app\models\User;
use app\modules\frontend\controllers\base\ModuleController;
use app\modules\frontend\models\ArticleValidator;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
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

    /**
     * Lists all Article models.
     * @return mixed
     */
    public function actionIndex()
    {
        $request = Yii::$app->request;
        $title = $request->get('title');
        $content = $request->get('content');
        $username = $request->get('username');
        $published_at = $request->get('published_at');

        $query = (new Query())
            ->from(['article' => Article::tableName()])
            ->select([
                'article.id',
                'title',
                'published_at',
                'user.username',
            ])
            ->leftJoin(['user' => User::tableName()], 'user.id = article.created_by')
            ->where([
                'visible' => Article::VISIBLE_YES,
                'article.status' => Article::STATUS_ENABLE,
            ])
            ->andWhere(['<=', 'published_at', time()])
            ->andFilterWhere(['like', 'title', $title])
            ->andFilterWhere(['like', 'content', $content])
            ->andFilterWhere(['user.username' => $username])
            ->timeRangeFilter('published_at', $published_at, true);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['published_at' => SORT_DESC],
                'attributes' => [
                    'title',
                    'content',
                    'username',
                    'published_at',
                ],
            ],
            'pagination' => [
                'pageSize' => 15,
            ],
        ]);

        return $this->render('index', [
            'title' => $title,
            'content' => $content,
            'username' => $username,
            'published_at' => $published_at,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionMyArticle()
    {
        $this->layout = '@app/views/layouts/user';

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
                Message::setSuccessMsg('删除成功');
            } else {
                Message::setErrorMsg('删除失败');
            }
        } else {
            Message::setErrorMsg('不能删除其他人的数据');
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
