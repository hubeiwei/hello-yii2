<?php

namespace app\modules\portal\controllers;

use app\models\Article;
use app\models\search\ArticleSearch;
use app\models\User;
use app\modules\core\helpers\EasyHelper;
use app\modules\core\helpers\UserHelper;
use app\modules\portal\controllers\base\ModuleController;
use app\modules\portal\models\ArticleForm;
use Yii;
use yii\data\Pagination;
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
     * TODO 我只会用GridView，现在自己弄的还没想好怎么做个好用的搜索，暂时先这样吧
     *
     * @return string
     */
    public function actionIndex()
    {
        $data = Article::find()
            ->select([
                'id',
                'title',
                'created_by',
                'user.username',
                'FROM_UNIXTIME(`published_at`, \'%m-%d %H:%i\' ) AS published_at'
            ])
            ->where(['<=', 'published_at', time()])
            ->where([
                'visible' => Article::VISIBLE_YES,
                Article::tableName() . '.status' => Article::STATUS_ENABLE,
            ])
            ->leftJoin(User::tableName(), User::tableName() . '.user_id = ' . Article::tableName() . '.created_by')
            ->orderBy(['published_at' => SORT_DESC]);

        $pages = new Pagination([
            'totalCount' => $data->count(),
            'pageSize' => 10,
        ]);

        $articles = $data->offset($pages->offset)->limit($pages->limit)->asArray()->all();

        return $this->render('index', [
            'articles' => $articles,
            'pages' => $pages,
        ]);

        /*$searchModel = new ArticleSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);*/
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
        }

        return $this->render('create', [
            'model' => $form,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if (!UserHelper::isBelongToUser($model->created_by)) {
            EasyHelper::setErrorMsg('不可修改其他人的数据');
            return $this->redirect(['index']);
        }

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

        return $this->render('update', [
            'model' => $form,
            'id' => $model->id,
        ]);
    }

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
