<?php

namespace app\modules\backend\controllers;

use app\common\helpers\Message;
use app\models\Music;
use app\models\search\MusicSearch;
use app\modules\backend\controllers\base\ModuleController;
use app\modules\frontend\models\MusicValidator;
use Yii;
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
        $validator = new MusicValidator();
        $validator->scenario = MusicValidator::SCENARIO_UPDATE;

        if ($request->isPost) {
            $flow = true;
            $originalFileName = $model->music_file;
            $model->load($request->post());
            $validator->load($request->post());
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
                        return $this->redirect(['index']);
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

        return $this->render('@app/modules/frontend/views/music/update', [
            'model' => $model,
            'validator' => $validator,
        ]);
    }

    /**
     * Deletes an existing Music model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        if ($model->delete()) {
            $model->deleteMusic();
            Message::setSuccessMsg('删除成功');
        } else {
            Message::setErrorMsg('删除失败');
        }

        return $this->redirect(['index']);
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
