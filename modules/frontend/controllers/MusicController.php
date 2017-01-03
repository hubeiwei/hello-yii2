<?php

namespace app\modules\frontend\controllers;

use app\common\helpers\Message;
use app\common\helpers\UserHelper;
use app\models\Music;
use app\models\search\MusicSearch;
use app\modules\frontend\controllers\base\ModuleController;
use app\modules\frontend\models\MusicValidator;
use Yii;
use yii\base\ErrorException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

/**
 * MusicController implements the CRUD actions for Music model.
 */
class MusicController extends ModuleController
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
                        ],
                    ],
                    [
                        'allow' => true,
                        'actions' => [
                            'my-music',
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
     * Lists all Music models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MusicSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionMyMusic()
    {
        $this->layout = '@app/views/layouts/user';

        $searchModel = new MusicSearch();
        $dataProvider = $searchModel->searchMyMusic(Yii::$app->request->queryParams);

        return $this->render('my-music', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Music model.
     * If creation is successful, the browser will be redirected to the 'index' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $model = new Music();
        $validator = new MusicValidator();
        $validator->scenario = MusicValidator::SCENARIO_CREATE;

        if ($request->isPost) {
            $data = $request->post();
            if (!UserHelper::isAdmin()) {
                // 因为设计的问题，不想改写rules，所以这样防止status被管理员之外的人修改
                unset($data[$model->formName()]['status']);
            }

            $flow = true;
            $model->load($data);
            $validator->load($data);
            $validator->music_file = UploadedFile::getInstance($validator, 'music_file');
            if (!$validator->validate()) {
                $flow = false;
            }
            if ($flow && !$model->uploadMusic($validator->music_file)) {
                $flow = false;
                $validator->addError('music_file', '文件上传失败');
            }
            if ($flow) {
                if ($model->save()) {
                    Message::setSuccessMsg('上传成功');
                    return $this->redirect(['index']);
                } else {
                    $model->deleteMusic();
                    Message::setErrorMsg('上传失败');
                }
            }
        }

        return $this->render('create', [
            'model' => $model,
            'validator' => $validator,
        ]);
    }

    /**
     * Updates an existing Music model.
     * If update is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);

        if (!UserHelper::isBelongToUser($model->user_id)) {
            Message::setErrorMsg('不可修改其他人的数据');
            return $this->redirect(['index']);
        }

        $validator = new MusicValidator();
        $validator->scenario = MusicValidator::SCENARIO_UPDATE;

        if ($request->isPost) {
            $data = $request->post();
            if (!UserHelper::isAdmin()) {
                // 因为设计的问题，不想改写rules，所以这样防止status被管理员之外的人修改
                unset($data[$model->formName()]['status']);
            }

            $flow = true;
            $originalFileName = $model->music_file;
            $model->load($data);
            $validator->load($data);
            $validator->music_file = UploadedFile::getInstance($validator, 'music_file');
            if ($validator->validate()) {
                //如果上传了新文件，则上传它
                if ($validator->music_file && !$model->uploadMusic($validator->music_file)) {
                    $validator->addError('music_file', '文件上传失败');
                    $flow = false;
                }
                if ($flow) {
                    if ($model->save()) {
                        //如果上传了新文件，删除原文件
                        if ($validator->music_file) {
                            $model->deleteMusic($originalFileName);
                        }
                        Message::setSuccessMsg('修改成功');
                        return $this->redirect(['my-music']);
                    } else {
                        //如果上传了新文件，删除新文件
                        if ($validator->music_file) {
                            $model->deleteMusic();
                        }
                        Message::setErrorMsg('修改失败');
                    }
                }
            }
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
            if (UserHelper::isBelongToUser($model->user_id)) {
                if ($model->delete()) {
                    $model->deleteMusic();
                    Message::setSuccessMsg('删除成功');
                } else {
                    Message::setErrorMsg('删除失败');
                }
            } else {
                Message::setErrorMsg('不能删除其他人的数据');
            }
            return $this->redirect(['my-music']);
        } else {
            if (UserHelper::isBelongToUser($model->user_id)) {
                if ($model->delete()) {
                    $model->deleteMusic();
                } else {
                    throw new ErrorException('删除失败');
                }
            } else {
                throw new ErrorException('不能删除其他人的数据');
            }
        }
    }

    /**
     * Finds the Music model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Music the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Music::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
